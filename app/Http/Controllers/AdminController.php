<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clock;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    // Get Dashboard Data
    public function dashboard()
    {
        $users = User::where('user_type', '!=', 'super-admin')->where(['user_type' => 'user', 'admin_id' => auth()->user()->id])->count();
        $usersArr = User::where('user_type', '!=', 'super-admin')->where(['user_type' => 'user', 'admin_id' => auth()->user()->id])->pluck('id')->toArray();
        $admins = User::where('user_type', '!=', 'super-admin')->where(['user_type' => 'user', 'admin_id' => auth()->user()->id])->count();
        $clocks = Clock::whereDate('created_at', Carbon::today())->wherein('user_id', $usersArr)->with('user')->orderby('created_at', 'DESC')->get();
        return view('admin.dashboard', compact('users', 'admins', 'clocks'));
    }

    // Get All Users
    public function getAllUsers(Request $request)
    {
        if ($request->has('name') && $request->name != '' || $request->has('email') && $request->email != '') {
            $users = User::where('user_type', '!=', 'super-admin')->where('user_type', 'user')->with('admins');

            if ($request->filled('name') && $request->name != '' || $request->filled('email') && $request->email != '') {
                $users->where('name', 'like', '%' . $request->input('name') . '%')->where('email', 'like', '%' . $request->input('email') . '%');
            }
            if ($request->filled('name')) {
                $users->where('name', 'like', '%' . $request->input('name') . '%');
            }

            if ($request->filled('email')) {
                $users->where('email', 'like', '%' . $request->input('email') . '%');
            }
            $users = $users->where('admin_id', auth()->user()->id)->get();
        } else {
            $users = User::where('user_type', '!=', 'super-admin')->where('user_type', 'user')->where('admin_id', auth()->user()->id)->with('admins')->get();
        }
        return view('admin.users', compact('users'));
    }

    // Edit User
    public function editUser($userId, $type)
    {
        $user = User::find($userId);
        return view('admin.edit-user', compact('user', 'type'));
    }

    public function editUserPost(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_type' => 'required|string|in:admin,user',
            'phone' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $request->userId,
        ];

        $data = $request->except('_token');
        $name = $request->first_name . ' ' . $request->last_name;
        $data['name'] = $name;
        unset($data['first_name']);
        unset($data['last_name']);
        if ($request->has('password') && $request->password != '') {
            $rules['password'] = 'required|min:8|same:password_confirmation';
            $rules['password_confirmation'] = 'required|min:8';
        } else {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['errors' => $errors], 400);
        }

        $user = User::find($request->userId);
        $user = $user->update($data);

        // Send email
        // if (!Mail::to($request->email)->send(new UserCredentials($request->email, $request->password))) {
        //     // Email sending failed
        //     return response()->json(['error' => 'Failed to send email'], 500);
        // }

        return response()->json($user, 201);
    }

    // Get All Time Logs
    public function timeLogs(Request $request)
    {
        // dd($request->all());
        $adminId = auth()->user()->id;
        $userIds = User::where('admin_id', $adminId)->pluck('id')->toArray();
        $query = Clock::query();
        $search = [];
        if ($request->has('name') && $request->name != '') {
            $search['name'] = $request->name;
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('name') . '%');
            });
        }

        if ($request->has('startDate') && $request->startDate != '') {
            $search['startDate'] = $request->startDate;
            $query->whereDate('time', '>=', date($request->startDate));
        }

        if ($request->has('endDate') && $request->endDate != '') {
            $search['endDate'] = $request->endDate;
            $query->whereDate('time', '<=', date($request->endDate));
        }
        $adminType = auth()->user()->user_type;
        if ($adminType == 'super-admin') {
            $users = User::where('user_type', 'user')->get();
        } else {
            $users = User::where('user_type', 'user')->where('admin_id', auth()->user()->id)->get();
        }
        $clocks = $query->wherein('user_id', $userIds)->with('user')->orderBy('created_at', 'DESC')->get();
        return view('admin.time-logs', compact('clocks', 'users', 'search'));
    }

    public function manualEntries($id)
    {
        $clock = Clock::findOrFail($id);
        $checkIn_clock = Clock::where('user_id', $clock->user_id)
            ->where('time', '<', $clock->time)
            ->orderBy('time', 'desc')
            ->first();
    
        $search = [
            'id' => $clock->id,
            'minutes' => $clock->minutes,
            'memo' => $clock->memo,
            'checkInTime' => $checkIn_clock ? $checkIn_clock->time : null,
            'checkInDate' => $checkIn_clock ? date('M d, Y', strtotime($checkIn_clock->time)) : null,
            'is_approved' => $clock->is_approved,
            'approved_by' => $clock->approved_by,
            'approval_notes' => $clock->approval_notes,
        ];
        return view('admin.manual-entry', compact('clock', 'checkIn_clock', 'search'));
    }    
    
    public function updateClock(Request $request)
    {
        $clock = Clock::findOrFail($request->id);
    
        if ($request->has('clock_out') && !empty($request->clock_out)) {
            $clockOutTime = new \DateTime($request->clock_out);
    
            $checkInClock = Clock::where('user_id', $clock->user_id)
                ->where('type', 'clock-in')
                ->where('time', '<', $clockOutTime->format('Y-m-d H:i:s'))
                ->orderBy('time', 'desc')
                ->first();
    
            if ($checkInClock) {
                $checkInTime = new \DateTime($checkInClock->time);
                $interval = $checkInTime->diff($clockOutTime);
                $calculatedMinutes = ($interval->h * 60) + $interval->i;
                $clock->time = $clockOutTime->format('Y-m-d H:i:s'); 
                $clock->minutes = $calculatedMinutes; 
            } else {
                return redirect()->back()->with('error', 'No matching check-in record found.');
            }
        } else {
            return redirect()->back()->with('error', 'Clock-out time cannot be empty.');
        }
    
        if ($request->has('memo') && !empty($request->memo)) {
            $clock->memo = $request->memo; 
        }
    
        $clock->save();
        return redirect()->route('admin.manualEntries', ['id' => $clock->id])->with('success', 'Clock updated successfully.');
    }

    public function pendingRequests()
    {
        $adminId = auth()->user()->id;
    
        $requests = Clock::where('is_approved', 1)
            ->where('type', 'clock-out')
            ->join('users', 'clocks.user_id', '=', 'users.id')
            ->where('users.admin_id', $adminId)
            ->select('clocks.*', 'users.name as user_name')
            ->get();
    
        return view('admin.pending-requests', compact('requests'));
    }
    
    public function approveRequest($id)
    {
        $clock = Clock::findOrFail($id);
        $currentMinutes = is_numeric($clock->minutes) ? (float) $clock->minutes : 0;
        $pendingMinutes = is_numeric($clock->pending_minutes) ? (float) $clock->pending_minutes : 0;
        if ($clock->is_approved === 1) {
            $clock->minutes = $currentMinutes + $pendingMinutes;
            $clock->pending_minutes = 0;
            if ($pendingMinutes > 0) {
                $checkInClock = Clock::where('user_id', $clock->user_id)
                    ->where('type', 'clock-in')
                    ->where('time', '<', $clock->time)
                    ->orderBy('time', 'desc')
                    ->first();
                if ($checkInClock) {
                    $checkInTime = new \DateTime($checkInClock->time);
                    $currentClockOutTime = new \DateTime($clock->time);
                    $interval = $checkInTime->diff($currentClockOutTime);
                    $newClockOutTime = $checkInTime->add($interval);
                    $newClockOutTime->modify("+{$pendingMinutes} minutes");
                    $clock->time = $newClockOutTime->format('Y-m-d H:i:s');
                }
            }
            $clock->is_approved = 2;
            $clock->status = 'approved';
            $clock->approved_by = auth()->id();
            $clock->save();
    
            return redirect()->route('admin.pendingRequest')->with('success', 'Request approved successfully.');
        }
    
        return redirect()->route('admin.pendingRequest')->with('error', 'Request cannot be approved.');
    }
    
    public function rejectRequest($id)
    {
        $clock = Clock::findOrFail($id);

        if ($clock->is_approved === 1) {
            $clock->is_approved = 3;
            $clock->status = 'rejected';
            $clock->approved_by = auth()->id();
            $clock->save();
            return redirect()->route('admin.pendingRequest')->with('success', 'Request rejected successfully.');
        }
        return redirect()->route('admin.pendingRequest')->with('error', 'Request cannot be rejected.');
    }
}

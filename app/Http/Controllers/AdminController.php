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

    public function manualEntries(Request $request)
    {
        // dd($request->all());
        $clock = Clock::find($request->clockId);
        $checkIn_clock = Clock::find($request->clockId - 1);
        $search = $request->all();
        // dd($search['name']);
        // dd($clock, $checkIn_clock);
        return view('admin.manual-entry', compact('clock', 'checkIn_clock', 'search'));
    }

    public function updateClock(Request $request)
    {
        // dd($request->all());
        $clock = Clock::find($request->id);
        if($request->has('memo') && $request->memo != null){
            $clock->memo = $request->memo;
        }
        $lastcheckIn = Clock::find($request->id-1);
        if ($clock->minutes != $request->minutes) {
            // if ($clock->minutes > $request->minutes) {
            //     // deduction in time made
            //     $diff = $clock->minutes - $request->minutes;
            //     $newTime = Carbon::parse($clock->time)->subMinutes($diff);
            //     $clock->time = $newTime;
            //     $clock->minutes = $request->minutes;
            // } else if ($clock->minutes < $request->minutes) {
            //     // addition in time made
            //     $diff =  $request->minutes - $clock->minutes;
            //     $newTime = Carbon::parse($clock->time)->addMinutes($diff);
            //     $clock->time = $newTime;
            //     $clock->minutes = $request->minutes;
            // }
            if ($request->minutes < 0) {
                return redirect()->back()->with('error', 'Minutes cannot be negative');
            }
            else {
                $clock->minutes = $request->minutes;
                $clock->time = Carbon::parse($lastcheckIn->time)->addMinutes($request->minutes);
            }
        }
        $res = $clock->save();
        if ($res) {
            return redirect()->route('admin.timeLogs');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
}

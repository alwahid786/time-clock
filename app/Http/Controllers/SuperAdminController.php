<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Clock;
use Illuminate\Support\Facades\Validator;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class SuperAdminController extends Controller
{

    // Get Dashboard Data
    public function dashboard()
    {
        $users = User::where('user_type', '!=', 'super-admin')->where('user_type', 'user')->count();
        $admins = User::where('user_type', '!=', 'super-admin')->where('user_type', 'admin')->count();
        $clocks = Clock::whereDate('created_at', Carbon::today())->with('user')->orderby('created_at', 'DESC')->get();
        return view('super-admin.dashboard', compact('users', 'admins', 'clocks'));
    }

    public function timeLogs(Request $request)
    {
        // dd($request->all());
        $query = Clock::query();
        if ($request->has('name') && $request->name != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', $request->name);
            });
        }

        if ($request->has('email') && $request->email != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', $request->email);
            });
        }

        if ($request->has('startDate') && $request->startDate != '') {
            $query->whereDate('created_at', '>=', $request->startDate);
        }

        if ($request->has('endDate') && $request->endDate != '') {
            $query->whereDate('created_at', '<=', $request->endDate);
        }
        $adminType = auth()->user()->user_type;
        if ($adminType == 'super-admin') {
            $users = User::where('user_type', 'user')->get();
        } else {
            $users = User::where('user_type', 'user')->where('admin_id', auth()->user()->id)->get();
        }
        $clocks = $query->with('user')->orderBy('created_at', 'DESC')->get();
        return view('super-admin.time-logs', compact('clocks', 'users'));
    }

    public function manualEntries()
    {
        $adminType = auth()->user()->user_type;
        if ($adminType == 'super-admin') {
            $users = User::where('user_type', 'user')->get();
        } else {
            $users = User::where('user_type', 'user')->where('admin_id', auth()->user()->id)->get();
        }
        return view('super-admin.manual-entry', compact('users'));
    }

    public function generateReport(Request $request)
    {
        $query = Clock::query();
        $startDate = Clock::orderBy('created_at', 'ASC')->pluck('time')->first();
        $startDate = date('d/m/Y', strtotime($startDate));
        $endDate = Carbon::now()->format('d/m/Y');
        $names = $request->reportnames;
        if ($request->has('reportnames')) {
            $query->wherein('user_id', $request->reportnames);
        }

        if ($request->has('reportstartdate') && $request->reportstartdate != null) {
            $query->whereDate('created_at', '>=', $request->reportstartdate);
            $startDate = date('d/m/Y', strtotime($request->reportstartdate));
        }

        if ($request->has('reportenddate') && $request->reportenddate != null) {
            $query->whereDate('created_at', '<=', $request->reportenddate);
            $endDate = date('d/m/Y', strtotime($request->reportenddate));
        }
        $clocks = $query->with('user')->orderBy('created_at', 'DESC')->get();
        // Group the clocks by user name and date
        $groupedClocks = [];
        foreach ($clocks as $clock) {
            $userName = $clock->user->name;
            $date = $clock->created_at->toDateString();
            if (!isset($groupedClocks[$userName])) {
                $groupedClocks[$userName] = [];
            }
            if (!isset($groupedClocks[$userName][$date])) {
                $groupedClocks[$userName][$date] = [
                    'clocks' => [],
                    'total_hours' => 0,
                ];
            }
            $groupedClocks[$userName][$date]['clocks'][] = $clock;
        }


        return view('super-admin.reports', compact('groupedClocks', 'startDate', 'endDate', 'names'));
    }


    // Get All Users
    public function getAllUsers()
    {
        $users = User::where('user_type', '!=', 'super-admin')->where('user_type', 'user')->with('admins')->get();
        return view('super-admin.users', compact('users'));
    }

    // Get All Admins
    public function getAllAdmins()
    {
        $admins = User::where('user_type', '!=', 'super-admin')->where('user_type', 'admin')->with('admins')->get();
        if ($admins) {
            foreach ($admins as $admin) {
                $admin['userCount'] = User::where('admin_id', $admin->id)->count();
            }
        }
        return view('super-admin.admins', compact('admins'));
    }

    // Edit User
    public function editUser($userId, $type)
    {
        $user = User::find($userId);
        return view('super-admin.edit-user', compact('user', 'type'));
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
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('user/images'), $imageName);
            $profileImg = 'user/images/' . $imageName;
            $data['profile_img'] = $profileImg;
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

    public function importUser(Request $request)
    {
        try {
            $file = $request->file('file');
            Excel::import(new UsersImport, $file);
            $skippedRowsCount = (new UsersImport)->getSkippedRowsCount();
            $message = 'Users imported successfully!';
            if ($skippedRowsCount > 0) {
                $message .= " $skippedRowsCount rows were skipped due to duplicate emails.";
            }
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }
}

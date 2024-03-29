<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class SuperAdminController extends Controller
{

    // Get Dashboard Data
    public function dashboard()
    {
        $users = User::where('user_type', '!=', 'super-admin')->where('user_type', 'user')->count();
        $admins = User::where('user_type', '!=', 'super-admin')->where('user_type', 'admin')->count();
        return view('super-admin.dashboard', compact('users', 'admins'));
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

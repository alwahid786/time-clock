<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Clock;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentials;
use App\Mail\ForgotPasswordMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()], 422);
            }
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(['message' => 'You have logged in successfully.', 'user_type' => auth()->user()->user_type], 200);
            } else {
                return response()->json(['error' => 'Wrong Credentials'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => [$e->getMessage()]], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        // Validate the email address
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid email address'], 400);
        }

        // Generate OTP
        $otp = mt_rand(1000, 9999);
        // Store OTP in the database
        User::where('email', $request->email)->update(['otp' => $otp]);
        Session::put('email', $request->email);
        try {
            // Send OTP to the user's email address
            Mail::to($request->email)->send(new ForgotPasswordMail($otp));
            return response()->json(['message' => 'An email containing 4 digits OTP code has been sent to registered email.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send OTP'], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        // Validate the email address
        $validator = Validator::make($request->all(), [
            'otp' => 'required|min:4',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid otp format'], 400);
        }

        $email = Session::get('email');
        if ($email) {
            // Store OTP in the database
            $user = User::where('email', $email)->first();
            if ($user->otp == $request->otp) {
                return response()->json(['message' => 'OTP Successfully Verified, Proceed to Password Reset.'], 200);
            } else {
                return response()->json(['error' => 'Failed to verify OTP, Invalid OTP entered.'], 500);
            }
        } else {
            return response()->json(['error' => 'Session expired, Re-enter email.'], 500);
        }
    }
    public function updatePassword(Request $request)
    {
        // Validate the email address
        $validator = Validator::make($request->all(), [
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => 'Password must have minimum 8 digits.'], 400);
        }
        $email = Session::get('email');
        if ($email) {
            // Store OTP in the database
            $user = User::where('email', $email)->update(['password' => bcrypt($request->password)]);
            if ($user) {
                return response()->json(['message' => 'Password successfully reset!'], 200);
            } else {
                return response()->json(['error' => 'Failed to reset your password, Try again.'], 500);
            }
        } else {
            return response()->json(['error' => 'Session expired, Re-enter email.'], 500);
        }
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'user_type' => 'required|string|in:admin,user',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['errors' => $errors], 400);
        }

        $adminId = auth()->user()->id;
        // Handle image upload
        $profileImg = null;
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('user/images'), $imageName);
            $profileImg = 'user/images/' . $imageName;
        }
        $user = [
            'name' => $request->first_name . ' ' . $request->last_name,
            'user_type' => $request->user_type,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'admin_id' => $adminId,
            'profile_img' => $profileImg,
        ];
        // $user = User::create($user);

        // Send email
        if (!Mail::to($request->email)->send(new UserCredentials($request->email, $request->password))) {
            // Email sending failed
            return response()->json(['error' => 'Failed to send email'], 500);
        }

        return response()->json($user, 201);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('loginView');
    }
    public function applyCLock(Request $request)
    {
        $now = Carbon::now();
        $clock = new Clock();
        $clock->user_id = auth()->user()->id;
        $clock->type = strtolower($request->type);
        if ($request->type == 'Clock-out') {
            $previousClockTime = Clock::where('user_id', auth()->user()->id)->where('type', 'clock-in')->orderBy('created_at', 'DESC')->pluck('time')->first();
            if ($previousClockTime) {
                $previousClockTime = Carbon::parse($previousClockTime);
                $clock->minutes = $previousClockTime->diffInMinutes($now);
            }
        }
        if ($request->memo != '' || $request->memo != null) {
            $clock->memo = $request->memo;
        }
        $clock->time = $now;
        $success = $clock->save();
        if ($success) {
            return response()->json("Clock Time Updated Successfully!", 201);
        } else {
            return response()->json("Time was not updated! Something went wrong", 500);
        }
    }
    public function userDashboard()
    {
        $clock = Clock::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->first();
        $admin = User::where('id', auth()->user()->admin_id)->first();
        return view('users.dashboard', compact('clock', 'admin'));
    }
}

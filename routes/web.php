<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Universal Auth View Routes
Route::get('/login', function () {
    return view('users.user-login');
})->name('loginView');
Route::get('/forget-password', function () {
    return view('users.forgot-password');
});
Route::get('/otp-code', function () {
    return view('users.otp-code');
})->name('otpView');
Route::get('/reset-password', function () {
    return view('users.reset-password');
})->name('resetPasswordView');

// Authentication POST Routes
Route::post('login', [UserController::class, 'login']);
Route::post('forgot-password', [UserController::class, 'forgotPassword']);
Route::post('otp-verification', [UserController::class, 'verifyOtp']);
Route::post('update-password', [UserController::class, 'updatePassword']);
Route::post('add-user', [UserController::class, 'addUser']);
Route::post('edit-user', [SuperAdminController::class, 'editUserPost']);
Route::post('import-excel', [SuperAdminController::class, 'importUser'])->name('import-users');


// Logout Route
Route::get('logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

// Super-Admin & Admin Routes
Route::middleware('user.type:admin')->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('adminDashboard');

        Route::get('/time-logs', function () {
            return view('admin.time-logs');
        })->name('admin.timeLogs');
        Route::get('/reports', function () {
            return view('admin.reports');
        })->name('reports');
        Route::get('/all-users', function () {
            return view('admin.users');
        })->name('admin.users');
        Route::get('/all-users', [AdminController::class, 'getAllUsers'])->name('admin.users'); // Get All Users for Admin
        Route::get('/edit-user/{userId}/{type}', [AdminController::class, 'editUser'])->name('admin.editUser'); // Edit User

        Route::get('/add-user', function () {
            return view('admin.add-user');
        })->name('admin.addUser');
    });
});
Route::middleware('user.type:super-admin')->group(function () {
    Route::prefix('super-admin')->group(function () {

        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('superAdminDashboard');
        Route::any('/time-logs', [SuperAdminController::class, 'timeLogs'])->name('timeLogs');
        Route::any('/generate-report', [SuperAdminController::class, 'generateReport'])->name('generateReport');
        Route::any('/generate-pdf', [PDFController::class, 'generatePdf'])->name('generatePdf');
        Route::get('/manual-entry/{clockId}', [SuperAdminController::class, 'manualEntries'])->name('manualEntries');
        Route::post('/update-clock', [SuperAdminController::class, 'updateClock'])->name('updateClock');
        // Route::get('/time-logs', function () {
        //     return view('super-admin.time-logs');
        // })->name('timeLogs');
        Route::get('/reports', function () {
            return view('super-admin.reports');
        })->name('reports');
        Route::any('/all-users', [SuperAdminController::class, 'getAllUsers'])->name('superAdminUsers'); // Get All Users
        Route::get('/all-admins', [SuperAdminController::class, 'getAllAdmins'])->name('adminsList'); // Get All Admins
        Route::get('/edit-user/{userId}/{type}', [SuperAdminController::class, 'editUser'])->name('editUser'); // Edit User


        Route::get('/add-user', function () {
            return view('super-admin.add-user');
        })->name('addNewUser');
    });
});

// User Routes
Route::middleware('user.type:user')->group(function () {
    Route::prefix('user')->group(function () {
        // Route::get('/dashboard', function () {
        //     return view('users.dashboard');
        // })->name('userDashboard');
        Route::get('dashboard', [UserController::class, 'userDashboard'])->name('userDashboard');
    });
    Route::post('clock', [UserController::class, 'applyCLock'])->name('applyClock');

});

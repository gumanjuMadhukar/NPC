<?php

use App\Http\Controllers\Site\APIController;
use App\Http\Controllers\Site\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::name('auth-')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('register/{is_foreign}', [AuthController::class, 'register'])->name('register');
    // Route::get('foreign-register', [AuthController::class, 'foreignRegister'])->name('foreign-register');
    Route::post('register/save', [AuthController::class, 'registerSave'])->name('register-save');
    Route::post('check/login', [AuthController::class, 'checkLogin'])->name('checkLogin');
    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('otp', [AuthController::class, 'otp'])->name('otp');
    Route::get('reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    Route::post('save-password', [AuthController::class, 'savePassword'])->name('save-password');
});

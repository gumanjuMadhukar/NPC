<?php

use App\Http\Controllers\AdmitCardReader\AccountController;
use App\Http\Controllers\AdmitCardReader\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth.admit_card_reader'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admit_card_reader-dashboard');
    Route::prefix('exam')->group(function () {
        Route::get('/detail/{id}',[DashBoardController::class, 'examDetail'])->name('admit_card_reader-dashboard-exam-detail');
        Route::get('/export', [DashBoardController::class, 'export'])->name('admit_card_reader-dashboard-exam-export');
    });
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('admit_card_reader-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('admit_card_reader-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('admit_card_reader-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('admit_card_reader-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('admit_card_reader-logout');
    });
});

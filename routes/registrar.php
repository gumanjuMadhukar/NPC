<?php

use App\Http\Controllers\Registrar\AccountController;
use App\Http\Controllers\Registrar\ApplicantController;
use App\Http\Controllers\Registrar\DashboardController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth.registrar'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('registrar-dashboard');
    Route::prefix('exam')->group(function () {
        Route::get('/detail/{id}',[DashBoardController::class, 'examDetail'])->name('registrar-dashboard-exam-detail');
    });
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('registrar-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('registrar-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('registrar-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('registrar-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('registrar-logout');
    });
    Route::prefix('applicant')->group(function () {
        Route::get('/', [ApplicantController::class, 'myList'])->name('registrar-applicant-list');
        Route::get('/search', [ApplicantController::class,'list'])->name('registrar-all-applicant-list');
        Route::get('/approved-list', [ApplicantController::class, 'approvedList'])->name('registrar-applicant-approved-list');
        Route::get('/rejected-list', [ApplicantController::class, 'rejectedList'])->name('registrar-applicant-rejected-list');
        Route::get('/pending-list', [ApplicantController::class, 'pendingList'])->name('registrar-applicant-pending-list');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('registrar-applicant-profile');
        Route::get('/status', [ApplicantController::class, 'status'])->name('registrar-applicant-status');
        Route::post('/save-status', [ApplicantController::class, 'statusSave'])->name('registrar-applicant-save-status');
        Route::get('/apply-form/{id}', [ApplicantController::class, 'applyForm'])->name('registrar-applicant-apply-form');
        Route::post('/move-applicants-to-subject_committee',[ApplicantController::class , 'moveApplicantsToSubjectCommittee'])->name('registrar-applicant-move-to-subject_committee');
    });
});

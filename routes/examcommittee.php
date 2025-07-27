<?php

use App\Http\Controllers\ExamCommittee\AccountController;
use App\Http\Controllers\ExamCommittee\ApplicantController;
use App\Http\Controllers\ExamCommittee\DashboardController;
use App\Http\Controllers\ExamCommittee\AdmitCardController;
use App\Http\Controllers\ExamCommittee\ResultController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth.exam_committee'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('exam_committee-dashboard');
    // Route::prefix('exam')->group(function () {
    //     Route::get('/{id}',[DashBoardController::class, 'examDetail'])->name('exam_committee-dashboard-exam-detail');
    // });
    Route::prefix('exam')->group(function () {
        Route::get('/detail/{id}',[DashBoardController::class, 'examDetail'])->name('exam_committee-dashboard-exam-detail');
    });
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('exam_committee-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('exam_committee-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('exam_committee-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('exam_committee-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('exam_committee-logout');
    });
    Route::prefix('applicant')->group(function () {
        Route::get('/', [ApplicantController::class,'list'])->name('exam_committee-applicant-list');
        Route::get('/search', [ApplicantController::class,'list'])->name('exam_committee-all-applicant-list');
        Route::get('/approved_list', [ApplicantController::class,'approvedList'])->name('exam_committee-applicant-approved-list');
        Route::get('/rejected_list', [ApplicantController::class,'rejectedList'])->name('exam_committee-applicant-rejected-list');
        Route::get('/pending_list', [ApplicantController::class,'pendingList'])->name('exam_committee-applicant-pending-list');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('exam_committee-applicant-profile');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('exam_committee-applicant-profile');
        Route::post('/status', [ApplicantController::class, 'status'])->name('exam_committee-applicant-status');
        Route::post('/admitcard_generate', [AdmitCardController::class, 'generate'])->name('exam_committee-admitcard-generate');
        Route::get('/routine_generate', [AdmitCardController::class, 'generateRoutine'])->name('exam_committee-routine-generate');
        Route::get('/export', [AdmitCardController::class, 'export'])->name('exam_committee-applicant-export');
        Route::get('/result/list/{exam_id}', [ResultController::class, 'list'])->name('exam_committee-result-list');
        Route::get('/result/upload', [ResultController::class, 'form'])->name('exam_committee-result-form');
        Route::post('/result/upload', [ResultController::class, 'result_upload'])->name('exam_committee-result-upload');
    });
});

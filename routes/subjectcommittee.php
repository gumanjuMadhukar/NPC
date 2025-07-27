<?php

use App\Http\Controllers\SubjectCommittee\AccountController;
use App\Http\Controllers\SubjectCommittee\ApplicantController;
use App\Http\Controllers\SubjectCommittee\DashboardController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth.subject_committee'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('subject_committee-dashboard');
    Route::prefix('exam')->group(function () {
        Route::get('/{id}',[DashBoardController::class, 'examDetail'])->name('subject_committee-dashboard-exam-detail');
    });
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('subject_committee-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('subject_committee-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('subject_committee-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('subject_committee-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('subject_committee-logout');
    });
    Route::prefix('applicant')->group(function () {
        Route::get('/', [ApplicantController::class,'myList'])->name('subject_committee-applicant-list');
        Route::get('/search', [ApplicantController::class,'list'])->name('subject_committee-all-applicant-list');
        Route::get('/approved-list', [ApplicantController::class,'approvedList'])->name('subject_committee-applicant-approved-list');
        Route::get('/rejected-list', [ApplicantController::class,'myRejectedList'])->name('subject_committee-applicant-rejected-list');
        Route::get('/committee-rejected-list', [ApplicantController::class,'committeeRejectedList'])->name('subject_committee-applicant-committee-rejected-list');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('subject_committee-applicant-profile');
        Route::post('/status', [ApplicantController::class, 'status'])->name('subject_committee-applicant-status');
        Route::get('/move-council', [ApplicantController::class, 'moveCouncil'])->name('subject_committee-move-council');
        Route::get('/move-examcommittee-list', [ApplicantController::class, 'moveExamcommitteeList'])->name('subject_committee-move-examcommittee-list');
        Route::get('/move-examcommittee', [ApplicantController::class, 'moveExamcommittee'])->name('subject_committee-move-examcommittee');
        Route::get('/{level_id}', [ApplicantController::class,'myListLevel'])->name('subject_committee-applicant-list-level');

    });

});







<?php

use App\Http\Controllers\Council\AccountController;
use App\Http\Controllers\Council\ApplicantController;
use App\Http\Controllers\Council\DashboardController;
use App\Http\Controllers\Council\CertificateController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth.council'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('council-dashboard');
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('council-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('council-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('council-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('council-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('council-logout');
    });

    Route::prefix('applicant')->group(function () {
        Route::get('/passed-list', [ApplicantController::class,'passedList'])->name('council-applicant-passed-list');
        Route::get('/tslc', [ApplicantController::class,'councilTslcApplicantList'])->name('council-tslc-applicant-list');
        Route::get('/tslc/certificate_form', [CertificateController::class,'createTslc'])->name('council-tslc-certificate-form');
        Route::post('/tslc/certificate/generate', [CertificateController::class,'moveTslcToDarta'])->name('move_tslc_to_darta');
        Route::get('/certificate_form', [CertificateController::class,'createCertificate'])->name('council-certificate-form');
        Route::post('/certificate/generate', [CertificateController::class,'moveToDarta'])->name('move_to_darta');
        Route::get('/certificate/darta-book', [CertificateController::class,'dartaList'])->name('council-darta-book');
        Route::get('/certificate/darta-book-detail/{program_id}/{decision_date}', [CertificateController::class,'dartaDetail'])->name('council-darta-book-detail');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('council-applicant-profile');
        // Route::get('/status', [ApplicantController::class, 'status'])->name('officer-applicant-status');
        // Route::post('/save-status', [ApplicantController::class, 'statusSave'])->name('officer-applicant-save-status');
    });
});







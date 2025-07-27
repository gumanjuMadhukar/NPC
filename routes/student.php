<?php

use App\Http\Controllers\Student\AccountController;
use App\Http\Controllers\Student\AdmitCardController;
use App\Http\Controllers\Student\CertificateController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Student\ExamController;
use App\Http\Controllers\Student\ForeignCertificateController;
use App\Http\Controllers\Student\ICardController;
use App\Http\Controllers\Student\KhaltiController;
use App\Http\Controllers\Student\KycController;
use App\Http\Controllers\Student\PaymentController;
use App\Http\Controllers\Student\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth.student'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('student-dashboard');
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('student-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('student-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('student-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('student-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('student-logout');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/personal', [ProfileController::class, 'personal'])->name('student-profile-personal');
        Route::post('/imageDelete', [ProfileController::class, 'imageDelete'])->name('student-profile-imageDelete');
        Route::post('/savePersonal', [ProfileController::class, 'savePersonal'])->name('student-profile-save-personal');
        Route::post('/saveForeignPersonal', [ProfileController::class, 'saveForeignPersonal'])->name('student-profile-save-foreign-personal');
        Route::get('/guardian', [ProfileController::class, 'guardian'])->name('student-profile-guardian');
        Route::post('/saveGuardian', [ProfileController::class, 'saveGuardian'])->name('student-profile-save-guardian');
        Route::post('/saveForeignGuardian', [ProfileController::class, 'saveForeignGuardian'])->name('student-profile-save-foreign_guardian');
        Route::post('/college-imageDelete', [ProfileController::class, 'collegeImageDelete'])->name('student-profile-college-imageDelete');
        Route::get('/slc', [ProfileController::class, 'slc'])->name('student-profile-slc');
        Route::post('/save-slc', [ProfileController::class, 'saveSlc'])->name('student-profile-save-slc');
        Route::get('/tslc', [ProfileController::class, 'tslc'])->name('student-profile-tslc');
        Route::post('/save-tslc', [ProfileController::class, 'saveTslc'])->name('student-profile-save-tslc');
        Route::get('/pcl', [ProfileController::class, 'pcl'])->name('student-profile-pcl');
        Route::post('/save-pcl', [ProfileController::class, 'savePcl'])->name('student-profile-save-pcl');
        Route::get('/bachelor', [ProfileController::class, 'bachelor'])->name('student-profile-bachelor');
        Route::post('/save-bachelor', [ProfileController::class, 'saveBachelor'])->name('student-profile-save-bachelor');
        Route::get('/master', [ProfileController::class, 'master'])->name('student-profile-master');
        Route::post('/save-master', [ProfileController::class, 'saveMaster'])->name('student-profile-save-master');
        Route::get('/voucher', [ProfileController::class, 'voucher'])->name('student-profile-voucher');
        Route::post('/save-voucher', [ProfileController::class, 'saveVoucher'])->name('student-profile-save-voucher');
        Route::post('/voucher-imageDelete', [ProfileController::class, 'voucherImageDelete'])->name('student-profile-voucher-imageDelete');
    });

    Route::prefix('exam')->group(function () {
        Route::get('/', [ExamController::class, 'index'])->name('student-exam-dashboard');
        Route::get('/history', [ExamController::class, '
        '])->name('student-exam-history');
        Route::get('/apply', [ExamController::class, 'apply'])->name('student-exam-apply');
        Route::post('/save-apply', [ExamController::class, 'saveApply'])->name('student-exam-save-apply');
        Route::get('/status', [ExamController::class, 'status'])->name('student-exam-status');
        Route::post('/voucher-imageDelete', [ExamController::class, 'voucherImageDelete'])->name('student-exam-voucher-imageDelete');

    });

    Route::prefix('kyc')->group(function () {
        Route::get('/', [KycController::class, 'index'])->name('student-kyc');
        Route::post('/save-kyc', [KycController::class, 'saveKyc'])->name('student-kyc-save');
    });

    Route::prefix('admitcard')->group(function () {
        Route::get('/', [AdmitCardController::class, 'admitcard'])->name('student-admitcard');
    });
    Route::prefix('foreignCertificate')->group(function () {
        Route::get('/', [ForeignCertificateController::class, 'foreignCertificate'])->name('student-foreign-certificate');
        Route::post('/apply', [ForeignCertificateController::class, 'saveForeignApply'])->name('student-foreign-certificate-apply');
    });
    Route::prefix('certificate')->group(function () {
        Route::get('/', [CertificateController::class, 'certificate'])->name('student-certificate');
        Route::post('/apply', [CertificateController::class, 'saveCertificateApply'])->name('student-certificate-apply');
    });
    Route::prefix('idcard')->group(function () {
        Route::get('/', [ICardController::class, 'idcard'])->name('student-idcard');
    });
    Route::prefix('payment')->group(function () {
        Route::get('/', [KhaltiController::class, 'paymentRequest'])->name('student-khalti-request');
        Route::get('/responses', [KhaltiController::class, 'paymentResponse'])->name('student-khalti-response');
        // Unified multi-gateway routes
        Route::post('/initiate/{gateway}/{purpose}', [PaymentController::class, 'initiate'])->name('student-payment-initiate');
        Route::post('/initiate1/{gateway}/{purpose}', [PaymentController::class, 'initiate1'])->name('student-payment-initiate1');
        Route::get('/callback/{gateway}/{purpose}', [PaymentController::class, 'callback'])->name('student-payment-callback');
    });
});

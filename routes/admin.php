<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ApplicantController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Admin\MunicipalityController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectCommitteeController;
use App\Http\Controllers\Admin\UniversityController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CertificateController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth.admin'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin-dashboard');
    Route::prefix('exam')->group(function () {
        Route::get('/detail/{id}',[DashBoardController::class, 'examDetail'])->name('admin-dashboard-exam-detail');
        Route::get('/export', [DashBoardController::class, 'export'])->name('admin-dashboard-exam-export');
    });
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('admin-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('admin-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('admin-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('admin-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('admin-logout');
    });

    Route::prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'list'])->name('admin-level');
        Route::post('/status', [LevelController::class, 'status'])->name('admin-level-status');
        Route::get('/addedit', [LevelController::class, 'addEdit'])->name('admin-level-addedit');
        Route::post('/store', [LevelController::class, 'store'])->name('admin-level-store');
        Route::get('/export', [LevelController::class, 'export'])->name('admin-level-export');
    });

    Route::prefix('college')->group(function () {
        Route::get('/', [CollegeController::class, 'list'])->name('admin-college');
        Route::post('/status', [CollegeController::class, 'status'])->name('admin-college-status');
        Route::get('/addedit', [CollegeController::class, 'addEdit'])->name('admin-college-addedit');
        Route::post('/store', [CollegeController::class, 'store'])->name('admin-college-store');
    });
    Route::prefix('university')->group(function () {
        Route::get('/', [UniversityController::class, 'list'])->name('admin-university');
        Route::post('/status', [UniversityController::class, 'status'])->name('admin-university-status');
        Route::get('/addedit', [UniversityController::class, 'addEdit'])->name('admin-university-addedit');
        Route::post('/store', [UniversityController::class, 'store'])->name('admin-university-store');
    });

    Route::prefix('province')->group(function () {
        Route::get('/', [ProvinceController::class, 'list'])->name('admin-province');
        Route::post('/status', [ProvinceController::class, 'status'])->name('admin-province-status');
        Route::get('/addedit', [ProvinceController::class, 'addEdit'])->name('admin-province-addedit');
        Route::post('/store', [ProvinceController::class, 'store'])->name('admin-province-store');
    });

    Route::prefix('district')->group(function () {
        Route::get('/', [DistrictController::class, 'list'])->name('admin-district');
        Route::post('/status', [DistrictController::class, 'status'])->name('admin-district-status');
        Route::get('/addedit', [DistrictController::class, 'addEdit'])->name('admin-district-addedit');
        Route::post('/store', [DistrictController::class, 'store'])->name('admin-district-store');
    });

    Route::prefix('municipality')->group(function () {
        Route::get('/', [MunicipalityController::class, 'list'])->name('admin-municipality');
        Route::post('/status', [MunicipalityController::class, 'status'])->name('admin-municipality-status');
        Route::get('/addedit', [MunicipalityController::class, 'addEdit'])->name('admin-municipality-addedit');
        Route::post('/store', [MunicipalityController::class, 'store'])->name('admin-municipality-store');
    });

    Route::prefix('subjectcommittee')->group(function () {
        Route::get('/', [SubjectCommitteeController::class, 'list'])->name('admin-subjectcommittee');
        Route::post('/status', [SubjectCommitteeController::class, 'status'])->name('admin-subjectcommittee-status');
        Route::get('/addedit', [SubjectCommitteeController::class, 'addEdit'])->name('admin-subjectcommittee-addedit');
        Route::post('/store', [SubjectCommitteeController::class, 'store'])->name('admin-subjectcommittee-store');
    });

    Route::prefix('exam')->group(function () {
        Route::get('/', [ExamController::class, 'list'])->name('admin-exam');
        Route::post('/status', [ExamController::class, 'status'])->name('admin-exam-status');
        Route::get('/addedit', [ExamController::class, 'addEdit'])->name('admin-exam-addedit');
        Route::post('/store', [ExamController::class, 'store'])->name('admin-exam-store');
    });

    Route::prefix('program')->group(function () {
        Route::get('/', [ProgramController::class, 'list'])->name('admin-program');
        Route::post('/status', [ProgramController::class, 'status'])->name('admin-program-status');
        Route::get('/addedit', [ProgramController::class, 'addEdit'])->name('admin-program-addedit');
        Route::post('/store', [ProgramController::class, 'store'])->name('admin-program-store');
        Route::get('/export', [ProgramController::class, 'export'])->name('admin-program-export');
    });

    Route::prefix('student')->group(function () {
        Route::get('/', [StudentController::class, 'list'])->name('admin-student');
        Route::post('/delete', [StudentController::class, 'delete'])->name('admin-student-delete');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'list'])->name('admin-user');
        Route::post('/status', [UserController::class, 'status'])->name('admin-user-status');
        Route::get('/addedit', [UserController::class, 'addEdit'])->name('admin-user-addedit');
        Route::post('/store', [UserController::class, 'store'])->name('admin-user-store');
        Route::post('/delete', [UserController::class, 'delete'])->name('admin-user-delete');
    });

    Route::prefix('applicant')->group(function () {
        Route::get('/', [ApplicantController::class,'list'])->name('admin-applicant-list');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('admin-applicant-profile');
        Route::get('/admitcard/{id}/{exam_id}', [ApplicantController::class, 'admitCard'])->name('admin-applicant-admitcard');
    });
    Route::get('/migrate_duplicate_certificate', [CertificateController::class, 'migrate_duplicate_certificate'])->name('admin-migrate-duplicate-certificate');
});

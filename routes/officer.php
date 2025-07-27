<?php

use App\Http\Controllers\Officer\AccountController;
use App\Http\Controllers\Officer\ApplicantController;
use App\Http\Controllers\Officer\CollegeController;
use App\Http\Controllers\Officer\DashboardController;
use App\Http\Controllers\Officer\DistrictController;
use App\Http\Controllers\Officer\ExamController;
use App\Http\Controllers\Officer\LevelController;
use App\Http\Controllers\Officer\MunicipalityController;
use App\Http\Controllers\Officer\ProgramController;
use App\Http\Controllers\Officer\ProvinceController;
use App\Http\Controllers\Officer\UniversityController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth.officer'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('officer-dashboard');
    Route::prefix('exam')->group(function () {
        Route::get('/detail/{id}',[DashBoardController::class, 'examDetail'])->name('officer-dashboard-exam-detail');
        Route::get('/{status}/{exam_id}',[DashBoardController::class, 'statusWiseList'])->name('officer-dashboard-exam-statuswise-detail');

    });
    Route::prefix('exam')->group(function () {
        Route::get('/{id}',[DashboardController::class, 'examDetail'])->name('officer-dashboard-exam-detail');

    });
    Route::prefix('program')->group(function () {
        Route::get('/{program_id}/{exam_id}',[DashBoardController::class, 'programWiseStudents'])->name('officer-dashboard-program-detail');
    });
    
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('officer-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('officer-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('officer-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('officer-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('officer-logout');
    });

    Route::prefix('applicant')->group(function () {
        Route::get('/', [ApplicantController::class,'myList'])->name('officer-applicant-list');
        Route::get('/search', [ApplicantController::class,'list'])->name('officer-all-applicant-list');
        Route::get('/approved_list', [ApplicantController::class,'approved_list'])->name('officer-applicant-approved-list');
        Route::get('/rejected_list', [ApplicantController::class,'rejected_list'])->name('officer-applicant-rejected-list');
        Route::get('/pending_list', [ApplicantController::class,'pending_list'])->name('officer-applicant-pending-list');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('officer-applicant-profile');
        Route::get('/export', [ApplicantController::class, 'export'])->name('officer-applicant-export');
        Route::get('/export/program_wise', [ApplicantController::class, 'export_program_wise'])->name('officer-applicant-programwise-export');
        Route::get('/status', [ApplicantController::class, 'status'])->name('officer-applicant-status');
        Route::post('/save-status', [ApplicantController::class, 'statusSave'])->name('officer-applicant-save-status');
    });

     Route::prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'list'])->name('officer-level');
        Route::post('/status', [LevelController::class, 'status'])->name('officer-level-status');
        Route::get('/addedit', [LevelController::class, 'addEdit'])->name('officer-level-addedit');
        Route::post('/store', [LevelController::class, 'store'])->name('officer-level-store');
    });

    Route::prefix('college')->group(function () {
        Route::get('/', [CollegeController::class, 'list'])->name('officer-college');
        Route::post('/status', [CollegeController::class, 'status'])->name('officer-college-status');
        Route::get('/addedit', [CollegeController::class, 'addEdit'])->name('officer-college-addedit');
        Route::post('/store', [CollegeController::class, 'store'])->name('officer-college-store');
    });
    Route::prefix('university')->group(function () {
        Route::get('/', [UniversityController::class, 'list'])->name('officer-university');
        Route::post('/status', [UniversityController::class, 'status'])->name('officer-university-status');
        Route::get('/addedit', [UniversityController::class, 'addEdit'])->name('officer-university-addedit');
        Route::post('/store', [UniversityController::class, 'store'])->name('officer-university-store');
    });

    Route::prefix('province')->group(function () {
        Route::get('/', [ProvinceController::class, 'list'])->name('officer-province');
        Route::post('/status', [ProvinceController::class, 'status'])->name('officer-province-status');
        Route::get('/addedit', [ProvinceController::class, 'addEdit'])->name('officer-province-addedit');
        Route::post('/store', [ProvinceController::class, 'store'])->name('officer-province-store');
    });

    Route::prefix('district')->group(function () {
        Route::get('/', [DistrictController::class, 'list'])->name('officer-district');
        Route::post('/status', [DistrictController::class, 'status'])->name('officer-district-status');
        Route::get('/addedit', [DistrictController::class, 'addEdit'])->name('officer-district-addedit');
        Route::post('/store', [DistrictController::class, 'store'])->name('officer-district-store');
    });

    Route::prefix('municipality')->group(function () {
        Route::get('/', [MunicipalityController::class, 'list'])->name('officer-municipality');
        Route::post('/status', [MunicipalityController::class, 'status'])->name('officer-municipality-status');
        Route::get('/addedit', [MunicipalityController::class, 'addEdit'])->name('officer-municipality-addedit');
        Route::post('/store', [MunicipalityController::class, 'store'])->name('officer-municipality-store');
    });

    Route::prefix('exam')->group(function () {
        Route::get('/', [ExamController::class, 'list'])->name('officer-exam');
        Route::post('/status', [ExamController::class, 'status'])->name('officer-exam-status');
        Route::get('/addedit', [ExamController::class, 'addEdit'])->name('officer-exam-addedit');
        Route::post('/store', [ExamController::class, 'store'])->name('officer-exam-store');
    });

    Route::prefix('program')->group(function () {
        Route::get('/', [ProgramController::class, 'list'])->name('officer-program');
        Route::post('/status', [ProgramController::class, 'status'])->name('officer-program-status');
        Route::get('/addedit', [ProgramController::class, 'addEdit'])->name('officer-program-addedit');
        Route::post('/store', [ProgramController::class, 'store'])->name('officer-program-store');
    });
    
});







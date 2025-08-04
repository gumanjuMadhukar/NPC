<?php

use App\Http\Controllers\OfficeAdmin\AccountController;
use App\Http\Controllers\OfficeAdmin\ApplicantController;
use App\Http\Controllers\OfficeAdmin\CollegeController;
use App\Http\Controllers\OfficeAdmin\DashboardController;
use App\Http\Controllers\OfficeAdmin\DistrictController;
use App\Http\Controllers\OfficeAdmin\ExamController;
use App\Http\Controllers\OfficeAdmin\FeeController;
use App\Http\Controllers\OfficeAdmin\LevelController;
use App\Http\Controllers\OfficeAdmin\MunicipalityController;
use App\Http\Controllers\OfficeAdmin\ProgramController;
use App\Http\Controllers\OfficeAdmin\ProvinceController;
use App\Http\Controllers\OfficeAdmin\UniversityController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth.office_admin'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('office_admin-dashboard');
    Route::prefix('exam')->group(function () {
        Route::get('/detail/{id}', [DashBoardController::class, 'examDetail'])->name('office_admin-dashboard-exam-detail');
        Route::get('/export', [DashBoardController::class, 'export'])->name('office_admin-dashboard-exam-export');
    });
    Route::prefix('applicant')->group(function () {
        Route::get('/', [ApplicantController::class,'myList'])->name('office_admin-applicant-list');
        Route::get('/search', [ApplicantController::class,'list'])->name('office_admin-all-applicant-list');
        Route::get('/state/{exam_id}',[DashBoardController::class, 'stateWiseList'])->name('office_admin-dashboard-exam-statewise-detail');
        Route::get('/approved_list', [ApplicantController::class,'approvedList'])->name('office_admin-applicant-approved-list');
        Route::get('/rejected_list', [ApplicantController::class,'rejectedList'])->name('office_admin-applicant-rejected-list');
        Route::get('/pending_list', [ApplicantController::class,'pendingList'])->name('office_admin-applicant-pending-list');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('office_admin-applicant-profile');
        Route::get('/export', [ApplicantController::class, 'export'])->name('office_admin-applicant-export');
        Route::get('/export/program_wise', [ApplicantController::class, 'export_program_wise'])->name('office_admin-applicant-programwise-export');
        Route::get('/forward_reexam', [ApplicantController::class, 'fowrardReExam'])->name('office_admin-fowrard-reexam');
        Route::post('/selected_forward_reexam', [ApplicantController::class, 'selectedFowrardReExam'])->name('office_admin-selected-fowrard-reexam');
        Route::get('/status', [ApplicantController::class, 'status'])->name('office_admin-applicant-status');
        Route::post('/save-status', [ApplicantController::class, 'statusSave'])->name('office_admin-applicant-save-status');
        Route::post('/save-state', [ApplicantController::class, 'stateSave'])->name('office_admin-applicant-save-state');
        Route::get('/personal-info/{id}', [ApplicantController::class, 'personalInfo'])->name('office_admin-applicant-personal-info');
        Route::post('/save-personal', [ApplicantController::class, 'savePersonalInfo'])->name('office_admin-applicant-save-personal');
        Route::get('/tslc/{id}', [ApplicantController::class, 'tslc'])->name('office_admin-applicant-tslc');
        Route::post('/save-tslc', [ApplicantController::class, 'saveTslc'])->name('office_admin-applicant-save-tslc');
        Route::get('/slc/{id}', [ApplicantController::class, 'slc'])->name('office_admin-applicant-slc');
        Route::post('/save-slc', [ApplicantController::class, 'saveSlc'])->name('office_admin-applicant-save-slc');
        Route::get('/pcl/{id}', [ApplicantController::class, 'pcl'])->name('office_admin-applicant-pcl');
        Route::post('/save-pcl', [ApplicantController::class, 'savePcl'])->name('office_admin-applicant-save-pcl');
        Route::get('/bachelor/{id}', [ApplicantController::class, 'bachelor'])->name('office_admin-applicant-bachelor');
        Route::post('/save-bachelor', [ApplicantController::class, 'saveBachelor'])->name('office_admin-applicant-save-bachelor');
        Route::get('/master/{id}', [ApplicantController::class, 'master'])->name('office_admin-applicant-master');
        Route::post('/save-master', [ApplicantController::class, 'saveMaster'])->name('office_admin-applicant-save-master');
        Route::get('/apply-form/{id}', [ApplicantController::class, 'applyForm'])->name('office_admin-applicant-apply-form');
        Route::post('/edit-apply', [ApplicantController::class, 'editApply'])->name('office_admin-applicant-edit-apply');
        Route::post('/delete', [ApplicantController::class, 'delete'])->name('office_admin-applicant-delete-application');
        Route::get('/admitcard/{exam_apply_id}', [ApplicantController::class, 'admitCard'])->name('office_admin-applicant-admitcard');
    });
    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('office_admin-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('office_admin-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('office_admin-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('office_admin-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('office_admin-logout');
    });
    Route::prefix('exam')->group(function () {
        Route::get('/', [ExamController::class, 'list'])->name('office_admin-exam');
        Route::post('/status', [ExamController::class, 'status'])->name('office_admin-exam-status');
        Route::get('/addedit', [ExamController::class, 'addEdit'])->name('office_admin-exam-addedit');
        Route::post('/store', [ExamController::class, 'store'])->name('office_admin-exam-store');
    });
    Route::prefix('fee')->group(function () {
        Route::get('/', [FeeController::class, 'list'])->name('office_admin-fee');
        Route::post('/status', [FeeController::class, 'status'])->name('office_admin-fee-status');
        Route::get('/addedit', [FeeController::class, 'addEdit'])->name('office_admin-fee-addedit');
        Route::post('/store', [FeeController::class, 'store'])->name('office_admin-fee-store');
    });
    Route::prefix('program')->group(function () {
        Route::get('/', [ProgramController::class, 'list'])->name('office_admin-program');
        Route::post('/status', [ProgramController::class, 'status'])->name('office_admin-program-status');
        Route::get('/addedit', [ProgramController::class, 'addEdit'])->name('office_admin-program-addedit');
        Route::post('/store', [ProgramController::class, 'store'])->name('office_admin-program-store');
    });
    Route::prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'list'])->name('office_admin-level');
        Route::post('/status', [LevelController::class, 'status'])->name('office_admin-level-status');
        Route::get('/addedit', [LevelController::class, 'addEdit'])->name('office_admin-level-addedit');
        Route::post('/store', [LevelController::class, 'store'])->name('office_admin-level-store');
    });
    Route::prefix('college')->group(function () {
        Route::get('/', [CollegeController::class, 'list'])->name('office_admin-college');
        Route::post('/status', [CollegeController::class, 'status'])->name('office_admin-college-status');
        Route::get('/addedit', [CollegeController::class, 'addEdit'])->name('office_admin-college-addedit');
        Route::post('/store', [CollegeController::class, 'store'])->name('office_admin-college-store');
    });
    Route::prefix('university')->group(function () {
        Route::get('/', [UniversityController::class, 'list'])->name('office_admin-university');
        Route::post('/status', [UniversityController::class, 'status'])->name('office_admin-university-status');
        Route::get('/addedit', [UniversityController::class, 'addEdit'])->name('office_admin-university-addedit');
        Route::post('/store', [UniversityController::class, 'store'])->name('office_admin-university-store');
    });
    Route::prefix('province')->group(function () {
        Route::get('/', [ProvinceController::class, 'list'])->name('office_admin-province');
        Route::post('/status', [ProvinceController::class, 'status'])->name('office_admin-province-status');
        Route::get('/addedit', [ProvinceController::class, 'addEdit'])->name('office_admin-province-addedit');
        Route::post('/store', [ProvinceController::class, 'store'])->name('office_admin-province-store');
    });
    Route::prefix('district')->group(function () {
        Route::get('/', [DistrictController::class, 'list'])->name('office_admin-district');
        Route::post('/status', [DistrictController::class, 'status'])->name('office_admin-district-status');
        Route::get('/addedit', [DistrictController::class, 'addEdit'])->name('office_admin-district-addedit');
        Route::post('/store', [DistrictController::class, 'store'])->name('office_admin-district-store');
    });
    Route::prefix('municipality')->group(function () {
        Route::get('/', [MunicipalityController::class, 'list'])->name('office_admin-municipality');
        Route::post('/status', [MunicipalityController::class, 'status'])->name('office_admin-municipality-status');
        Route::get('/addedit', [MunicipalityController::class, 'addEdit'])->name('office_admin-municipality-addedit');
        Route::post('/store', [MunicipalityController::class, 'store'])->name('office_admin-municipality-store');
    });
    Route::prefix('applicant')->group(function () {
        Route::get('/', [ApplicantController::class,'myList'])->name('office_admin-applicant-list');
        Route::get('/search', [ApplicantController::class,'list'])->name('office_admin-all-applicant-list');
        Route::get('/state/{exam_id}',[DashBoardController::class, 'stateWiseList'])->name('office_admin-dashboard-exam-statewise-detail');
        Route::get('/approved_list', [ApplicantController::class,'approvedList'])->name('office_admin-applicant-approved-list');
        Route::get('/rejected_list', [ApplicantController::class,'rejectedList'])->name('office_admin-applicant-rejected-list');
        Route::get('/pending_list', [ApplicantController::class,'pendingList'])->name('office_admin-applicant-pending-list');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('office_admin-applicant-profile');
        Route::get('/export', [ApplicantController::class, 'export'])->name('office_admin-applicant-export');
        Route::get('/export/program_wise', [ApplicantController::class, 'export_program_wise'])->name('office_admin-applicant-programwise-export');
        Route::get('/forward_reexam', [ApplicantController::class, 'fowrardReExam'])->name('office_admin-fowrard-reexam');
        Route::post('/selected_forward_reexam', [ApplicantController::class, 'selectedFowrardReExam'])->name('office_admin-selected-fowrard-reexam');
        Route::get('/status', [ApplicantController::class, 'status'])->name('office_admin-applicant-status');
        Route::post('/save-status', [ApplicantController::class, 'statusSave'])->name('office_admin-applicant-save-status');
        Route::post('/save-state', [ApplicantController::class, 'stateSave'])->name('office_admin-applicant-save-state');
        Route::get('/personal-info/{id}', [ApplicantController::class, 'personalInfo'])->name('office_admin-applicant-personal-info');
        Route::post('/save-personal', [ApplicantController::class, 'savePersonalInfo'])->name('office_admin-applicant-save-personal');
        Route::get('/tslc/{id}', [ApplicantController::class, 'tslc'])->name('office_admin-applicant-tslc');
        Route::post('/save-tslc', [ApplicantController::class, 'saveTslc'])->name('office_admin-applicant-save-tslc');
        Route::get('/slc/{id}', [ApplicantController::class, 'slc'])->name('office_admin-applicant-slc');
        Route::post('/save-slc', [ApplicantController::class, 'saveSlc'])->name('office_admin-applicant-save-slc');
        Route::get('/pcl/{id}', [ApplicantController::class, 'pcl'])->name('office_admin-applicant-pcl');
        Route::post('/save-pcl', [ApplicantController::class, 'savePcl'])->name('office_admin-applicant-save-pcl');
        Route::get('/bachelor/{id}', [ApplicantController::class, 'bachelor'])->name('office_admin-applicant-bachelor');
        Route::post('/save-bachelor', [ApplicantController::class, 'saveBachelor'])->name('office_admin-applicant-save-bachelor');
        Route::get('/master/{id}', [ApplicantController::class, 'master'])->name('office_admin-applicant-master');
        Route::post('/save-master', [ApplicantController::class, 'saveMaster'])->name('office_admin-applicant-save-master');
        Route::get('/apply-form/{id}', [ApplicantController::class, 'applyForm'])->name('office_admin-applicant-apply-form');
        Route::post('/edit-apply', [ApplicantController::class, 'editApply'])->name('office_admin-applicant-edit-apply');
        Route::post('/delete', [ApplicantController::class, 'delete'])->name('office_admin-applicant-delete-application');
        Route::get('/admitcard/{exam_apply_id}', [ApplicantController::class, 'admitCard'])->name('office_admin-applicant-admitcard');
    });
});

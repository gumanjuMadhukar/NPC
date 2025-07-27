<?php

use App\Http\Controllers\Operator\AccountController;
use App\Http\Controllers\Operator\ApplicantController;
use App\Http\Controllers\Operator\CertificateController;
use App\Http\Controllers\Operator\CollegeController;
use App\Http\Controllers\Operator\DashboardController;
use App\Http\Controllers\Operator\DistrictController;
use App\Http\Controllers\Operator\ExamController;
use App\Http\Controllers\Operator\KYCController;
use App\Http\Controllers\Operator\LevelController;
use App\Http\Controllers\Operator\MunicipalityController;
use App\Http\Controllers\Operator\ProgramController;
use App\Http\Controllers\Operator\ProvinceController;
use App\Http\Controllers\Operator\SubjectCommitteeController;
use App\Http\Controllers\Operator\UniversityController;
use App\Http\Controllers\Operator\DuplicateCertificateController;
use App\Http\Controllers\Operator\FeeController;
use App\Models\SubjectCommittee;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth.operator'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('operator-dashboard');
    Route::prefix('exam')->group(function () {
        Route::get('/detail/{id}',[DashBoardController::class, 'examDetail'])->name('operator-dashboard-exam-detail');
        Route::get('/{status}/{exam_id}',[DashBoardController::class, 'statusWiseList'])->name('operator-dashboard-exam-statuswise-detail');

    });

    Route::prefix('program')->group(function () {
        Route::get('/{program_id}/{exam_id}',[DashBoardController::class, 'programWiseStudents'])->name('operator-dashboard-program-detail');
    });

    Route::prefix('account')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('operator-account-setting');
        Route::post('/store', [AccountController::class, 'store'])->name('operator-account-store');
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('operator-account-change-password');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('operator-account-update-password');
        Route::get('/logout', [AccountController::class, 'logout'])->name('operator-logout');
    });
    Route::prefix('applicant')->group(function () {
        Route::get('/', [ApplicantController::class,'myList'])->name('operator-applicant-list');
        Route::get('/search', [ApplicantController::class,'list'])->name('operator-all-applicant-list');
        Route::get('/state/{exam_id}',[DashBoardController::class, 'stateWiseList'])->name('operator-dashboard-exam-statewise-detail');
        Route::get('/approved_list', [ApplicantController::class,'approvedList'])->name('operator-applicant-approved-list');
        Route::get('/rejected_list', [ApplicantController::class,'rejectedList'])->name('operator-applicant-rejected-list');
        Route::get('/pending_list', [ApplicantController::class,'pendingList'])->name('operator-applicant-pending-list');
        Route::get('/profile/{id}', [ApplicantController::class, 'profile'])->name('operator-applicant-profile');
        Route::get('/export', [ApplicantController::class, 'export'])->name('operator-applicant-export');
        Route::get('/export/program_wise', [ApplicantController::class, 'export_program_wise'])->name('operator-applicant-programwise-export');
        Route::get('/forward_reexam', [ApplicantController::class, 'fowrardReExam'])->name('operator-fowrard-reexam');
        Route::post('/selected_forward_reexam', [ApplicantController::class, 'selectedFowrardReExam'])->name('operator-selected-fowrard-reexam');
        Route::get('/status', [ApplicantController::class, 'status'])->name('operator-applicant-status');
        Route::post('/save-status', [ApplicantController::class, 'statusSave'])->name('operator-applicant-save-status');
        Route::post('/save-state', [ApplicantController::class, 'stateSave'])->name('operator-applicant-save-state');
        Route::get('/personal-info/{id}', [ApplicantController::class, 'personalInfo'])->name('operator-applicant-personal-info');
        Route::post('/save-personal', [ApplicantController::class, 'savePersonalInfo'])->name('operator-applicant-save-personal');
        Route::get('/tslc/{id}', [ApplicantController::class, 'tslc'])->name('operator-applicant-tslc');
        Route::post('/save-tslc', [ApplicantController::class, 'saveTslc'])->name('operator-applicant-save-tslc');
        Route::get('/slc/{id}', [ApplicantController::class, 'slc'])->name('operator-applicant-slc');
        Route::post('/save-slc', [ApplicantController::class, 'saveSlc'])->name('operator-applicant-save-slc');
        Route::get('/pcl/{id}', [ApplicantController::class, 'pcl'])->name('operator-applicant-pcl');
        Route::post('/save-pcl', [ApplicantController::class, 'savePcl'])->name('operator-applicant-save-pcl');
        Route::get('/bachelor/{id}', [ApplicantController::class, 'bachelor'])->name('operator-applicant-bachelor');
        Route::post('/save-bachelor', [ApplicantController::class, 'saveBachelor'])->name('operator-applicant-save-bachelor');
        Route::get('/master/{id}', [ApplicantController::class, 'master'])->name('operator-applicant-master');
        Route::post('/save-master', [ApplicantController::class, 'saveMaster'])->name('operator-applicant-save-master');
        Route::get('/apply-form/{id}', [ApplicantController::class, 'applyForm'])->name('operator-applicant-apply-form');
        Route::post('/edit-apply', [ApplicantController::class, 'editApply'])->name('operator-applicant-edit-apply');
        Route::post('/delete', [ApplicantController::class, 'delete'])->name('operator-applicant-delete-application');
        Route::get('/admitcard/{exam_apply_id}', [ApplicantController::class, 'admitCard'])->name('operator-applicant-admitcard');
    });

    Route::prefix('certificate')->group(function () {
        Route::get('/', [CertificateController::class,'searchList'])->name('operator-certificate-list-all');
        Route::get('/print/{print_status}', [CertificateController::class,'list'])->name('operator-certificate-list');
        Route::get('/foreign', [CertificateController::class,'foreignCertificateList'])->name('operator-certificate-foreign-list');
        Route::get('/foreign-request', [CertificateController::class,'foreignCertificateRequestList'])->name('operator-certificate-foreign-request-list');
        Route::get('/certificate-issuance-request', [CertificateController::class,'certificateIssuanceRequestList'])->name('operator-certificate-issuance-request-list');
        Route::get('/foreign/profile/{id}', [CertificateController::class, 'profile'])->name('operator-certificate-profile');
        Route::get('/foreign/addedit', [CertificateController::class,'foreignAddEdit'])->name('operator-certificate-foreign-addedit');
        Route::get('/program-wise-list/{id}/{isPrinted}', [CertificateController::class,'programWiseList'])->name('operator-program-wise-certificate-list');
        // Route::get('/printed/{print_status}', [CertificateController::class,'list'])->name('operator-certificate-list');
        Route::get('/edit/{id}', [CertificateController::class,'edit'])->name('operator-certificate-edit');
        Route::get('/foreignedit/{id}', [CertificateController::class,'edit'])->name('operator-certificate-foreign-edit');
        Route::Post('/store/{id}', [CertificateController::class,'store'])->name('operator-certificate-store');
        Route::post('/foreignstore', [CertificateController::class,'foreignStore'])->name('operator-certificate-foreign-store');
        // Route::Post('/fstore', [CertificateController::class,'fstore'])->name('operator-certificate-fstore');
        Route::get('/profile/{id}', [CertificateController::class, 'profile'])->name('operator-certificate-profile');
        Route::get('/id_card/{id}', [CertificateController::class, 'idProfile'])->name('operator-id_card-profile');
        Route::post('/program_edit', [CertificateController::class, 'programEdit'])->name('operator-certificate-program-edit');
        Route::get('/duplicate', [CertificateController::class, 'duplicateCertificateList'])->name('operator-certificate-duplicate-list');
        Route::get('/duplicate/addedit', [CertificateController::class,'duplicateAddEdit'])->name('operator-certificate-duplicate-addedit');
        Route::post('/duplicatestore', [CertificateController::class,'duplicateStore'])->name('operator-certificate-duplicate-store');
        Route::post('/delete', [CertificateController::class, 'delete'])->name('operator-certificate-delete-certificate');

        Route::get('/duplicate/{id}', [DuplicateCertificateController::class, 'view'])->name('operator-duplicate_certificate_view');
    });

    Route::prefix('subject_committee')->group(function () {
        Route::get('/', [SubjectCommitteeController::class, 'list'])->name('operator-subject_committee-list');
    });

    Route::prefix('level')->group(function () {
        Route::get('/', [LevelController::class, 'list'])->name('operator-level');
        Route::post('/status', [LevelController::class, 'status'])->name('operator-level-status');
        Route::get('/addedit', [LevelController::class, 'addEdit'])->name('operator-level-addedit');
        Route::post('/store', [LevelController::class, 'store'])->name('operator-level-store');
    });

    Route::prefix('college')->group(function () {
        Route::get('/', [CollegeController::class, 'list'])->name('operator-college');
        Route::post('/status', [CollegeController::class, 'status'])->name('operator-college-status');
        Route::get('/addedit', [CollegeController::class, 'addEdit'])->name('operator-college-addedit');
        Route::post('/store', [CollegeController::class, 'store'])->name('operator-college-store');
    });

    Route::prefix('university')->group(function () {
        Route::get('/', [UniversityController::class, 'list'])->name('operator-university');
        Route::post('/status', [UniversityController::class, 'status'])->name('operator-university-status');
        Route::get('/addedit', [UniversityController::class, 'addEdit'])->name('operator-university-addedit');
        Route::post('/store', [UniversityController::class, 'store'])->name('operator-university-store');
    });

    Route::prefix('province')->group(function () {
        Route::get('/', [ProvinceController::class, 'list'])->name('operator-province');
        Route::post('/status', [ProvinceController::class, 'status'])->name('operator-province-status');
        Route::get('/addedit', [ProvinceController::class, 'addEdit'])->name('operator-province-addedit');
        Route::post('/store', [ProvinceController::class, 'store'])->name('operator-province-store');
    });

    Route::prefix('district')->group(function () {
        Route::get('/', [DistrictController::class, 'list'])->name('operator-district');
        Route::post('/status', [DistrictController::class, 'status'])->name('operator-district-status');
        Route::get('/addedit', [DistrictController::class, 'addEdit'])->name('operator-district-addedit');
        Route::post('/store', [DistrictController::class, 'store'])->name('operator-district-store');
    });

    Route::prefix('municipality')->group(function () {
        Route::get('/', [MunicipalityController::class, 'list'])->name('operator-municipality');
        Route::post('/status', [MunicipalityController::class, 'status'])->name('operator-municipality-status');
        Route::get('/addedit', [MunicipalityController::class, 'addEdit'])->name('operator-municipality-addedit');
        Route::post('/store', [MunicipalityController::class, 'store'])->name('operator-municipality-store');
    });

    Route::prefix('exam')->group(function () {
        Route::get('/', [ExamController::class, 'list'])->name('operator-exam');
        Route::post('/status', [ExamController::class, 'status'])->name('operator-exam-status');
        Route::get('/addedit', [ExamController::class, 'addEdit'])->name('operator-exam-addedit');
        Route::post('/store', [ExamController::class, 'store'])->name('operator-exam-store');
    });
    Route::prefix('fee')->group(function () {
        Route::get('/', [FeeController::class, 'list'])->name('operator-fee');
        Route::post('/status', [FeeController::class, 'status'])->name('operator-fee-status');
        Route::get('/addedit', [FeeController::class, 'addEdit'])->name('operator-fee-addedit');
        Route::post('/store', [FeeController::class, 'store'])->name('operator-fee-store');
    });

    Route::prefix('program')->group(function () {
        Route::get('/', [ProgramController::class, 'list'])->name('operator-program');
        Route::post('/status', [ProgramController::class, 'status'])->name('operator-program-status');
        Route::get('/addedit', [ProgramController::class, 'addEdit'])->name('operator-program-addedit');
        Route::post('/store', [ProgramController::class, 'store'])->name('operator-program-store');
    });

    Route::prefix('kyc')->group(function () {
        Route::get('/', [KYCController::class, 'list'])->name('operator-kyc');
        Route::post('/delete', [KYCController::class, 'delete'])->name('operator-kyc-delete');
        Route::get('/certificate', [KYCController::class, 'certificate'])->name('operator-kyc-certificate');
        Route::get('/allocate/{id}/{name}', [KYCController::class, 'allocate_form'])->name('operator-kyc-allocate_form');
        Route::post('/allocate/{id}', [KYCController::class, 'save'])->name('operator-kyc-allocate_save');
        Route::get('/json_list', [KYCController::class, 'json_list'])->name('operator-kyc-json-list');
    });
});







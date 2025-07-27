<?php

use App\Http\Controllers\Api\OnlinePaymentController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth.api'], function() {

    Route::prefix('v1')->group(function () {
        // General API Routes
        Route::get('/test', [OnlinePaymentController::class, 'test']);
        Route::get('/fetchUser', [OnlinePaymentController::class, 'fetchUser']);
        Route::get('/fetchNewCertUser', [OnlinePaymentController::class, 'fetchNewCertUser']);
        Route::post('/certificateRenewStore', [OnlinePaymentController::class, 'certificateRenewStore']);
        Route::post('/certificateIssuanceStore', [OnlinePaymentController::class, 'certificateIssuanceStore']);

        // Payment Integration Routes
        Route::prefix('payments')->group(function () {
            Route::post('/khalti/initiate', [OnlinePaymentController::class, 'initiateKhaltiPayment']);
            Route::post('/esewa/initiate', [OnlinePaymentController::class, 'initiateEsewaPayment']);
            Route::post('/verify', [OnlinePaymentController::class, 'verifyPayment']);
            Route::post('/update', [OnlinePaymentController::class, 'updatePaymentStatus']);
        });
    });
});

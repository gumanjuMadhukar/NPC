<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {
            Route::middleware('council')
                ->prefix('council')
                ->namespace('App\Http\Controllers\Council')
                ->group(base_path('routes/council.php'));
                
            Route::middleware('student')
                ->prefix('student')
                ->namespace('App\Http\Controllers\Student')
                ->group(base_path('routes/student.php'));

            Route::middleware('operator')
                ->prefix('operator')
                ->namespace('App\Http\Controllers\Operator')
                ->group(base_path('routes/operator.php'));

            Route::middleware('officer')
                ->prefix('officer')
                ->namespace('App\Http\Controllers\Officer')
                ->group(base_path('routes/officer.php'));

            Route::middleware('registrar')
                ->prefix('registrar')
                ->namespace('App\Http\Controllers\Registrar')
                ->group(base_path('routes/registrar.php'));
                
            Route::middleware('subject_committee')
                ->prefix('subject_committee')
                ->namespace('App\Http\Controllers\SubjectCommittee')
                ->group(base_path('routes/subjectcommittee.php'));
                
            Route::middleware('exam_committee')
                ->prefix('exam_committee')
                ->namespace('App\Http\Controllers\ExamCommittee')
                ->group(base_path('routes/examcommittee.php'));
                
            Route::middleware('admin')
                ->prefix('admin')
                ->namespace('App\Http\Controllers\Admin')
                ->group(base_path('routes/admin.php'));

            Route::middleware(['api', 'auth.api'])
                ->prefix(('api'))
                ->namespace('App\Http\Controllers\Api')
                ->group(base_path('routes/api.php'));
            Route::middleware('web')
                ->namespace('App\Http\Controllers\Site')
                ->group(base_path('routes/web.php'));

        }
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->use([
            // \Illuminate\Http\Middleware\TrustHosts::class,
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
            \App\Http\Middleware\HSTS::class,
            \App\Http\Middleware\SecureHeaders::class,
        ]);
        
        $middleware->appendToGroup('api', [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\ApiKeyMiddleware::class,
        ]);

        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->appendToGroup('student', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->appendToGroup('operator', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        $middleware->appendToGroup('officer', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        $middleware->appendToGroup('registrar', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        $middleware->appendToGroup('subject_committee', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        $middleware->appendToGroup('exam_committee', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        $middleware->appendToGroup('council', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->appendToGroup('admin', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->alias([
            'auth.admin' => \App\Http\Middleware\AdminAuthenticate::class,
            'auth.student' => \App\Http\Middleware\StudentAuthenticate::class,
            'auth.operator' => \App\Http\Middleware\OperatorAuthenticate::class,
            'auth.officer' => \App\Http\Middleware\OfficerAuthenticate::class,
            'auth.registrar' => \App\Http\Middleware\RegistrarAuthenticate::class,
            'auth.subject_committee' => \App\Http\Middleware\SubjectCommitteeAuthenticate::class,
            'auth.exam_committee' => \App\Http\Middleware\ExamCommitteeAuthenticate::class,  
            'auth.council' => \App\Http\Middleware\CouncilAuthenticate::class,
            'auth.api' => \App\Http\Middleware\ApiKeyMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        });
    })->create();

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminVideoController;
use App\Http\Controllers\admin\AdminFoundationController;
use App\Http\Controllers\superAdmin\SuperAdminController;
use App\Http\Controllers\superAdmin\SuperAdminVideoController;
use App\Http\Controllers\superAdmin\SuperAdminFoundationController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PublicSearchController;
use App\Http\Controllers\FoundationAuthController;
use App\Http\Controllers\FoundationController;
use App\Http\Controllers\PublicSelfAssessmentController;
use App\Http\Middleware\RoleManager;

Route::controller(MainController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/', 'search')->name('home.search');
    Route::get('/patient/{pasien}', 'show')
        ->name('public.patient.show')
        ->middleware('signed');
});

// Public self-assessment routes (no authentication required)
Route::controller(PublicSelfAssessmentController::class)->group(function () {
    Route::get('/self-assessment', 'index')->name('public.self-assessment.index');
    Route::post('/self-assessment', 'process')->name('public.self-assessment.process');
});

// Foundation authentication routes - REMOVED, now using unified login
// All foundation users should use the main login route with login_mode=foundation

// Foundation routes (authenticated)
Route::middleware(['auth', 'verified', RoleManager::class . ':foundation'])->group(function () {
    Route::prefix('foundation')->group(function () {
        Route::controller(FoundationController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('foundation.dashboard');
            Route::get('/pasiens', 'dashboard')->name('foundation.pasiens'); // Redirect to dashboard

            // Pasien management
            Route::get('/pasiens/create', 'create')->name('foundation.pasiens.create');
            Route::get('/pasiens/{pasien}', 'show')->name('foundation.pasiens.show');
            Route::post('/pasiens', 'store')->name('foundation.pasiens.store');
            Route::get('/pasiens/manage/{pasien}', 'manage')->name('foundation.pasiens.manage');
            Route::put('/pasiens/{pasien}', 'update')->name('foundation.pasiens.update');
            Route::delete('/pasiens/{pasien}', 'destroy')->name('foundation.pasiens.destroy');
        });
    });
});

Route::middleware(['auth', 'verified', RoleManager::class . ':admin'])->group(function () {
     Route::prefix('admin')->group(function (){
        Route::controller(AdminController::class)-> group(function(){
            Route::get('/dashboard', 'index')->name('admin');
            // Pasien management
            Route::get('/pasiens', 'pasiens')->name('admin.pasiens');
            Route::get('/pasiens/create', 'create')->name('admin.pasiens.create');
            Route::get('/pasiens/{pasien}', 'show')->name('admin.pasiens.show');
            // Route::get('/pasiens/manage', 'manage')->name('admin.pasiens.manage');
            Route::post('/pasiens', 'store')->name('admin.pasiens.store');
            Route::get('/pasiens/manage/{pasien}', 'manage')->name('admin.pasiens.manage');
            Route::put('/pasiens/{pasien}', 'update')->name('admin.pasiens.update');
            Route::delete('/pasiens/{pasien}', 'destroy')->name('admin.pasiens.destroy');
        });

        // Video management routes
        Route::controller(AdminVideoController::class)->group(function(){
            Route::get('/videos', 'index')->name('admin.videos.index');
            Route::get('/videos/create', 'create')->name('admin.videos.create');
            Route::post('/videos', 'store')->name('admin.videos.store');
            Route::get('/videos/{video}', 'show')->name('admin.videos.show');
            Route::get('/videos/{video}/edit', 'edit')->name('admin.videos.edit');
            Route::put('/videos/{video}', 'update')->name('admin.videos.update');
            Route::delete('/videos/{video}', 'destroy')->name('admin.videos.destroy');
            Route::patch('/videos/{video}/toggle', 'toggleStatus')->name('admin.videos.toggle');
        });

        // Foundation management routes
        Route::controller(AdminFoundationController::class)->group(function(){
            Route::get('/foundations', 'index')->name('admin.foundations.index');
            Route::get('/foundations/create', 'create')->name('admin.foundations.create');
            Route::post('/foundations', 'store')->name('admin.foundations.store');
            Route::get('/foundations/{foundation}', 'show')->name('admin.foundations.show');
            Route::get('/foundations/{foundation}/edit', 'edit')->name('admin.foundations.edit');
            Route::put('/foundations/{foundation}', 'update')->name('admin.foundations.update');
            Route::delete('/foundations/{foundation}', 'destroy')->name('admin.foundations.destroy');
            Route::patch('/foundations/{foundation}/toggle', 'toggleStatus')->name('admin.foundations.toggle');
        });
    });
});

Route::middleware(['auth', 'verified', RoleManager::class . ':superadmin'])->group(function () {
     Route::prefix('superadmin')->group(function (){
        Route::controller(SuperAdminController::class)-> group(function(){
             Route::get('/dashboard', 'index')->name('superadmin');

            // Admin management
            Route::get('/admins', 'admins')->name('superadmin.admins');
            Route::get('/admins/create', 'adminsCreate')->name('superadmin.admins.create');
            // Route::get('/admins/manage', 'adminsManage')->name('superadmin.admins.manage');
            Route::post('/admins', 'adminsStore')->name('superadmin.admins.store');
            Route::get('/admins/manage/{admin}', 'adminsManage')->name('superadmin.admins.manage');
            Route::put('/admins/{admin}', 'adminsUpdate')->name('superadmin.admins.update');
            Route::delete('/admins/{admin}', 'adminsDestroy')->name('superadmin.admins.destroy');

            // Admin password reset
            Route::post('/admins/{admin}/reset-password', 'adminsResetPassword')
                ->name('superadmin.admins.resetPassword');
            // Pasien management
            Route::get('/pasiens', 'pasiens')->name('superadmin.pasiens');
            Route::get('/pasiens/create', 'pasiensCreate')->name('superadmin.pasiens.create');
            Route::get('/pasiens/{pasien}', 'pasiensShow')->name('superadmin.pasiens.show');
            // Route::get('/pasiens/manage', 'pasiensManage')->name('superadmin.pasiens.manage');
            Route::post('/pasiens', 'pasiensStore')->name('superadmin.pasiens.store');
            Route::get('/pasiens/manage/{pasien}', 'pasiensManage')->name('superadmin.pasiens.manage');
            Route::put('/pasiens/{pasien}', 'pasiensUpdate')->name('superadmin.pasiens.update');
            Route::delete('/pasiens/{pasien}', 'pasiensDestroy')->name('superadmin.pasiens.destroy');
        });
        // Video management routes for superadmin
        Route::controller(SuperAdminVideoController::class)->group(function(){
            Route::get('/videos', 'index')->name('superadmin.videos.index');
            Route::get('/videos/create', 'create')->name('superadmin.videos.create');
            Route::post('/videos', 'store')->name('superadmin.videos.store');
            Route::get('/videos/{video}', 'show')->name('superadmin.videos.show');
            Route::get('/videos/{video}/edit', 'edit')->name('superadmin.videos.edit');
            Route::put('/videos/{video}', 'update')->name('superadmin.videos.update');
            Route::delete('/videos/{video}', 'destroy')->name('superadmin.videos.destroy');
            Route::patch('/videos/{video}/toggle', 'toggleStatus')->name('superadmin.videos.toggle');
        });

        // Foundation management routes for superadmin
        Route::controller(SuperAdminFoundationController::class)->group(function(){
            Route::get('/foundations', 'index')->name('superadmin.foundations.index');
            Route::get('/foundations/create', 'create')->name('superadmin.foundations.create');
            Route::post('/foundations', 'store')->name('superadmin.foundations.store');
            Route::get('/foundations/{foundation}', 'show')->name('superadmin.foundations.show');
            Route::get('/foundations/{foundation}/edit', 'edit')->name('superadmin.foundations.edit');
            Route::put('/foundations/{foundation}', 'update')->name('superadmin.foundations.update');
            Route::delete('/foundations/{foundation}', 'destroy')->name('superadmin.foundations.destroy');
            Route::patch('/foundations/{foundation}/toggle', 'toggleStatus')->name('superadmin.foundations.toggle');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

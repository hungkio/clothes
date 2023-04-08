<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\DesignController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\ConfirmPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\VerificationController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\UploadTinymceController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration Routes...
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // Password Confirmation Routes...
    Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);

    // Email Verification Routes...
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // Route Dashboards
    Route::middleware('auth')
        ->group(function () {
            // design
            Route::get('/', [DesignController::class, 'index'])->name('designs.index');
            Route::post('/bulk-delete', [DesignController::class, 'bulkDelete'])->name('designs.bulk-delete');
            Route::get('/create', [DesignController::class, 'create'])->name('designs.create');
            Route::post('/', [DesignController::class, 'store'])->name('designs.store');
            Route::get('/{post}/edit', [DesignController::class, 'edit'])->name('designs.edit');
            Route::delete('/{post}', [DesignController::class, 'destroy'])->name('designs.destroy');
            Route::put('/{post}', [DesignController::class, 'update'])->name('designs.update');
            Route::post('/{post}/status', [DesignController::class, 'changeStatus'])->name('designs.change.status');
            Route::post('/bulk-status', [DesignController::class, 'bulkStatus'])->name('designs.bulk.status');

            //staff
            Route::post('staffs/bulk-delete', [StaffController::class, 'bulkDelete'])->name('staffs.bulk-delete');
            Route::get('staffs', [StaffController::class, 'index'])->name('staffs.index');
            Route::get('staffs/create', [StaffController::class, 'create'])->name('staffs.create');
            Route::post('staffs', [StaffController::class, 'store'])->name('staffs.store');
            Route::get('staffs/{staff}/edit', [StaffController::class, 'edit'])->name('staffs.edit');
            Route::delete('staffs/{staff}', [StaffController::class, 'destroy'])->name('staffs.destroy');
            Route::put('staffs/{staff}', [StaffController::class, 'update'])->name('staffs.update');

            //brand
            Route::post('brands/bulk-delete', [BrandController::class, 'bulkDelete'])->name('brands.bulk-delete');
            Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
            Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
            Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
            Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
            Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
            Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');

            //Upload Tinymce
            Route::post('uploads-tinymce', UploadTinymceController::class)->name('public.upload-tinymce');

            // System Route
            Route::post('/admins/bulk-delete', [AdminController::class, 'bulkDelete'])->name('admins.bulk-delete');
            Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
            Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
            Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
            Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
            Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');
            Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');

            // POST
            Route::post('/posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');
            Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
            Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
            Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
            Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
            Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
            Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
            Route::post('/posts/{post}/status', [PostController::class, 'changeStatus'])->name('posts.change.status');
            Route::post('/posts/bulk-status', [PostController::class, 'bulkStatus'])->name('posts.bulk.status');

        });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Backend\ForgotPasswordController;

Route::get('/user/login', [AuthController::class, 'loginPage'])->name('user.login');
Route::post('/user/login', [AuthController::class, 'login'])->name('user.authenticate');
Route::get('/user/logout', [AuthController::class, 'logout'])->name('user.logout');

//for partner
Route::get('/auth/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('auth.showForgetPasswordForm');
Route::post('/auth/forgot-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('auth.submitForgetPasswordForm');
Route::get('/auth/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('auth.showResetPasswordForm');
Route::post('/auth/submitResetPasswordForm', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('auth.submitResetPasswordForm');

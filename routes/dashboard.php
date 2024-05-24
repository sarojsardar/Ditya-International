<?php

use App\Http\Controllers\Backend\ChangePasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;


Route::middleware(['auth:web'])->prefix('user')->group(function(){

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');

    // Change Password
    Route::get('/profile/change_password', [ChangePasswordController::class, 'changePassword'])->name('changePassword');
    // Check User Password
    Route::post('/profile/check-password', [ChangePasswordController::class, 'checkUserPassword'])->name('checkUserPassword');
    // Update Admin Password
    Route::post('/profile/update_password/{id}', [ChangePasswordController::class, 'upatePassword'])->name('upatePassword');

});


<?php

use App\Http\Controllers\Medical\MedicalAccessController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return redirect('/user/dashboard');
});

Route::group(['as'=>'medical-officer.'], function(){
    Route::group(['prefix'=>'candidate'], function(){
        Route::get('/', [MedicalAccessController::class, 'getIncheckupCandidates'])->name('candidate');
        Route::patch('{medical_checkup_id}', [MedicalAccessController::class, 'updateMedicalCheckupStatus'])->name('update-checkup-status');
    });
});





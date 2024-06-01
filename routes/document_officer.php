<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Document\DocumentAccessController;

Route::get('/', function(){
    return redirect('/user/dashboard');
});

Route::group(['as'=>'document-officer.'], function(){
    Route::group(['prefix'=>'candidate'], function(){
        Route::get('/', [DocumentAccessController::class, 'getInCandidates'])->name('candidate');
    });
});





<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Document\DocumentAccessController;

Route::get('/', function(){
    return redirect('/user/dashboard');
});
Route::group(['as'=>'document-officer.'], function(){
    Route::group(['prefix'=>'candidate'], function(){
        Route::get('/', [DocumentAccessController::class, 'getInCandidates'])->name('candidate');
        Route::get('/{company_candidate_id}', [DocumentAccessController::class, 'showDetails'])->name('show-candidate');
        Route::patch('document-status/{company_candidate_id}', [DocumentAccessController::class, 'updateDocumentStatus'])->name('document-status');
        Route::patch('/{company_candidate_id}', [DocumentAccessController::class, 'proceedToVisa'])->name('proceed-to-visa');
    });
});





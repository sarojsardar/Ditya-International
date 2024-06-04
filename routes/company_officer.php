<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\CompanyAccessController;

Route::get('/', function(){
    return redirect('/user/dashboard');
});
Route::group(['as'=>'company-officer.'], function(){
    Route::group(['prefix'=>'candidate'], function(){
        Route::get('/', [CompanyAccessController::class, 'getInCandidates'])->name('candidate');
        Route::get('/{company_candidate_id}', [CompanyAccessController::class, 'showDetails'])->name('show-candidate');
        Route::post('/', [CompanyAccessController::class, 'proceedToVisa'])->name('proceed-to-visa');
        Route::patch('document-status/{company_candidate_id}', [CompanyAccessController::class, 'updateDocumentStatus'])->name('document-status');
        Route::patch('notify-user/{company_candidate_id}', [CompanyAccessController::class, 'notifyDocumentRequirement'])->name('notify-user');
    });
});





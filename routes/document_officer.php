<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Document\DocumentAccessController;

Route::get('/', function(){
    return redirect('/user/dashboard');
});
Route::group(['as'=>'document-officer.'], function(){
    Route::group(['prefix'=>'candidate'], function(){

        Route::get('/get-data', [DocumentAccessController::class, 'getCandidates'])->name('candidate-data');
        
        Route::get('/', [DocumentAccessController::class, 'getInCandidates'])->name('candidate');
        Route::post('/', [DocumentAccessController::class, 'proceedToVisa'])->name('proceed-to-visa');
        
        Route::group(['prefix'=>'visa'], function(){
            Route::get('calling', [DocumentAccessController::class, 'visaCalling'])->name('visa-calling-candidate');
            Route::get('received', [DocumentAccessController::class, 'visaReceived'])->name('visa-received-candidate');
            Route::post('proceed-to-evisa', [DocumentAccessController::class, 'propceedToEvisa'])->name('proceed-to-evisa');
        });

        Route::group(['prefix'=>'e-visa'], function(){
            Route::get('calling', [DocumentAccessController::class, 'evisaCalling'])->name('evisa-calling-candidate');
            Route::get('received', [DocumentAccessController::class, 'evisaReceived'])->name('evisa-received-candidate');
        });
        Route::get('final-approval', [DocumentAccessController::class, 'finalApproval'])->name('candidate-final-approval');

        Route::patch('cancel/{company_candidate_id}', [DocumentAccessController::class, 'cancelCandidate'])->name('candidate-cancel');

        Route::get('ticketing', [DocumentAccessController::class, 'ticketing'])->name('candidate-ticketing');
        Route::get('engaged', [DocumentAccessController::class, 'engaged'])->name('candidate-engaged');
        Route::get('cancelled', [DocumentAccessController::class, 'cancelled'])->name('candidate-cancelled');

        Route::post('final-status', [DocumentAccessController::class, 'updateFinalstatus'])->name('candidate-final-status');
        Route::post('upload-visa', [DocumentAccessController::class, 'uploadFinalDocument'])->name('upload-candidate-document');
        Route::patch('document-upload/{company_candidate_id}', [DocumentAccessController::class, 'uploadDocument'])->name('document-upload');

        Route::get('/{company_candidate_id}', [DocumentAccessController::class, 'showDetails'])->name('show-candidate');
        Route::patch('document-status/{company_candidate_id}', [DocumentAccessController::class, 'updateDocumentStatus'])->name('document-status');
        Route::patch('notify-user/{company_candidate_id}', [DocumentAccessController::class, 'notifyDocumentRequirement'])->name('notify-user');
    });
});





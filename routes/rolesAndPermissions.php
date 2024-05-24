<?php

use App\Http\Controllers\Backend\RolesAndPermissionController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:web'])->prefix('user')->group(function(){

    //Roles routes
    Route::get('/roles', [RolesAndPermissionController::class, 'roles'])->name('user.roles');
    Route::get('/role/add', [RolesAndPermissionController::class, 'addRole'])->name('user.addRole');
    Route::post('/role/store', [RolesAndPermissionController::class, 'storeRole'])->name('user.storeRole');
    Route::get('/role/{id}/edit', [RolesAndPermissionController::class, 'editRole'])->name('user.editRole');
    Route::put('/role/{id}/update', [RolesAndPermissionController::class, 'updateRole'])->name('user.updateRole');
})

?>

<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CheckStepController;
use App\Http\Controllers\Api\InterviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VerifyController;
use App\Http\Controllers\Api\YearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SplashController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



//api route for countries
Route::get('/countries',[CountryController::class,'allCountries']);

Route::get('/category/list',[CategoryController::class,'allCategories']);

Route::get('/education/list',[EducationController::class,'allEducations']);

Route::get('/language/list',[LanguageController::class,'allLanguages']);

Route::get('/gender/list',[GenderController::class,'allGenders']);

Route::get('/year/list',[YearController::class,'allYears']);


Route::get('/splash',[SplashController::class,'getFirstSplash']);

//Blog List
Route::get('/blog/list', [BlogController::class, 'getBlogList']);

//Blog Details
Route::get('/blog/details/{slug}', [BlogController::class, 'getblogDetails']);


//Login & Register Routes

Route::post('/auth/register', [RegisterController::class, 'createUser']);

Route::post('/auth/login', [LoginController::class, 'loginUser']);

Route::post('/auth/user/verify', [VerifyController::class, 'verifyUser']);

// Endpoint for creating a password reset request
Route::post('/password/create-reset-request', [AuthController::class, 'createPasswordResetRequest']);

// Endpoint for resetting the password
Route::post('/password/reset', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::post('/personal/info', [UserController::class, 'updateUserDetails']);

    Route::post('/upload/photo', [UserController::class, 'uploadPhoto']);

    Route::post('/passport/info', [UserController::class, 'updatePassportDetails']);

    Route::post('/resume/info', [UserController::class, 'updateResumeDetails']);

    Route::post('/language/info', [UserController::class, 'updateLanguageDetails']);

    Route::post('/educational/document', [UserController::class, 'updateEducationalDetails']);

    Route::post('/work/experience', [UserController::class, 'updateWorkDetails']);

    Route::post('/bank/info', [UserController::class, 'updateBankDetails']);

    Route::post('/category/info', [UserController::class, 'updateCategoryDetails']);


    Route::get('/check/personal/info', [CheckStepController::class, 'checkUserDetailsFilled']);

    Route::get('/check/upload/photo', [CheckStepController::class, 'checkPhotoDetailsFilled']);

    Route::get('/check/passport/info', [CheckStepController::class, 'checkPassportDetailsFilled']);

    Route::get('/check/resume/info', [CheckStepController::class, 'checkResumeDetailsFilled']);

    Route::get('/check/language/info', [CheckStepController::class, 'checkLanguageDetailsFilled']);

    Route::get('/check/educational/document', [CheckStepController::class, 'checkEducationalDetailsFilled']);

    Route::get('/check/work/experience', [CheckStepController::class, 'checkWorkDetailsFilled']);

    Route::get('/check/bank/info', [CheckStepController::class, 'checkBankDetailsFilled']);

    Route::get('/check/category/info', [CheckStepController::class, 'checkCategoryDetailsFilled']);

    Route::get('/checkAllStep', [CheckStepController::class, 'checkAllDetailsFilled']);

    // Inverview Controller
    Route::get('/selectedByCompany', [InterviewController::class, 'selectedByCompany']);

    Route::get('/interviewInvites', [InterviewController::class, 'interviewInvites']);

    Route::post('/interviewStatus/{id}', [InterviewController::class, 'updateStatus'])->name('changeStatus');

});

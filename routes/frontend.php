<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientMessageController;
use App\Http\Controllers\Frontend\PageController;

Route::get('/', [PageController::class, 'index'])->name('web.home');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('web.aboutUs');
Route::get('/services', [PageController::class, 'services'])->name('web.services');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('web.contactUs');
Route::get('/service/{slug}', [PageController::class, 'singleService'])->name('web.singleService');


Route::get('/privacy-policies', [PageController::class, 'privacyPolicy'])->name('web.privacyPolicy');
Route::get('/new-vacancies', [PageController::class, 'vaccancy'])->name('web.vaccancy');
Route::get('/news', [PageController::class, 'news'])->name('web.news');
Route::get('/news/{slug}', [PageController::class, 'newsDetails'])->name('web.newsDetails');
Route::get('/gallery', [PageController::class, 'gallery'])->name('web.gallery');
Route::get('/gallery/{slug}', [PageController::class, 'galleryDetails'])->name('web.galleryDetails');
Route::get('/terms-and-Conditions', [PageController::class, 'termsAndConditions'])->name('web.termsAndConditions');
Route::get('/recruitment-process', [PageController::class, 'recruitment'])->name('web.recruitment');
Route::get('/vacancy/{demand_code}/details', [PageController::class, 'demandDetails'])->name('web.demandDetails');

//client message
Route::post('/message/store', [ClientMessageController::class, 'storeClientMessage'])->name('client.storeClientMessage');



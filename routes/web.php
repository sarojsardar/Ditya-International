<?php

use App\Http\Controllers\Backend\CandidateController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\EducationTypeController;
use App\Http\Controllers\Backend\GenderController;
use App\Http\Controllers\Backend\CompanyController;
use App\Http\Controllers\Backend\CompanyDemandController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\MasterSearchController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\PortfolioController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\SiteSettingController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SplashController;
use App\Http\Controllers\Backend\StaffController;
use App\Http\Controllers\Backend\WebcontentController;
use App\Http\Controllers\Backend\YearController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware(['auth:web'])->prefix('user')->group(function(){

    //staff routes
    Route::get('/list', [StaffController::class, 'index'])->name('staff.index')->middleware(['can:staff-read']);
    Route::get('/create', [StaffController::class, 'create'])->name('staff.create')->middleware(['can:staff-create']);
    Route::post('/store', [StaffController::class, 'store'])->name('staff.store')->middleware(['can:staff-create']);
    Route::get('/edit/{staff}', [StaffController::class, 'edit'])->name('staff.edit')->middleware(['can:staff-update']);
    Route::put('/update/{staff}', [StaffController::class, 'update'])->name('staff.update')->middleware(['can:staff-update']);

    //company
    ROute::get('/company-list', [CompanyController::class, 'index'])->name('company.index');
    ROute::get('/company/create', [CompanyController::class, 'create'])->name('company.create');
    ROute::post('/company/store', [CompanyController::class, 'store'])->name('company.store');
    ROute::get('/company-list/{id}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    ROute::put('/company-list/{id}/update', [CompanyController::class, 'update'])->name('company.update');
    ROute::get('/manager/company-list', [CompanyController::class, 'index'])->name('manager.company.index')->middleware(['can:manager-company-read']);

    ROute::get('/receptionist/company-list', [CompanyController::class, 'receptionist'])->name('receptionist.company.index')->middleware(['can:receptionist-company-read']);

    ROute::get('/medical-process', [CompanyController::class, 'receptionist'])->name('receptionist.medical.company.index')->middleware(['can:receptionist-company-read']);

    ROute::get('/medical-process', [CompanyController::class, 'receptionist'])->name('receptionist.medical.company.index')->middleware(['can:receptionist-company-read']);

    

    //company demand entry
    Route::get('/company-demand-entries', [CompanyDemandController::class, 'index'])->name('company-demand.index')->middleware(['can:demand-read']);
    Route::get('/company-demand-entry', [CompanyDemandController::class, 'create'])->name('company-demand.create')->middleware(['can:demand-create']);
    Route::post('/company-demand-entry/store', [CompanyDemandController::class, 'store'])->name('company-demand.store')->middleware(['can:demand-create']);
    Route::get('/company-demand-entry/edit/{id}', [CompanyDemandController::class, 'edit'])->name('company-demand.edit')->middleware(['can:demand-update']);
    Route::put('/company-demand-entry/update/{id}', [CompanyDemandController::class, 'update'])->name('company-demand.update')->middleware(['can:demand-update']);
    Route::get('/company-demand-entry/detail/{id}', [CompanyDemandController::class, 'detail'])->name('company-demand.detail')->middleware(['can:demand-read']);
    Route::get('/company-demand-entry/getCompanyDetail/{id}', [CompanyDemandController::class, 'getCompanyDetail'])->name('company-demand.getCompanyDetail')->middleware(['can:demand-create']);

    //Status
    Route::post('/user/{id}/status', [CompanyDemandController::class, 'updateStatus'])->name('changeStatus');

    Route::post('/status/{id}', [CompanyDemandController::class, 'statusUpdate'])->name('statusUpdate');
    Route::post('/users/update-status-notify', [CompanyDemandController::class, 'updateStatusAndNotify'])->name('users.update.status.notify');

    Route::post('/update-candidate-status', [CompanyDemandController::class, 'updateCandidateStatus'])->name('update-candidate-status');

    Route::post('/update-candidate-interview-status', [CompanyDemandController::class, 'updateCandidateInterviewStatus'])->name('update-candidate-interview-status');

    Route::post('/user/{userId}/comment', [CompanyDemandController::class, 'postComment'])->name('userComment.post');

    Route::post('/user/{userId}/interview', [CompanyDemandController::class, 'postInterview'])->name('userInterview.post');

    Route::post('/demands/{demandId}/notify', [CandidateController::class, 'sendDemandNotifications'])->name('demands.notify');

    //All Demands
    Route::get('/match-candidates', [CompanyDemandController::class, 'allIndex'])->name('all-demand.index')->middleware(['can:all-demand-read']);

    Route::get('/approved-candidates', [CompanyDemandController::class, 'approvedIndex'])->name('approved-demand.index')->middleware(['can:all-demand-read']);

    Route::get('/interview-candidates', [CompanyDemandController::class, 'interviewIndex'])->name('interview-demand.index')->middleware(['can:all-demand-read']);

    Route::get('/manager/approved-list/{companyId}', [CompanyDemandController::class, 'managerIndex'])->name('manager-demand.index');

    Route::get('/manager/interview-list/{companyId}', [CompanyDemandController::class, 'managerInterviewIndex'])->name('manager-interview-demand.index');

    Route::get('/receptionist/company-list/{companyId}', [CompanyDemandController::class, 'receptionistIndex'])->name('receptionist-demand.index');


    Route::get('/candidate/demand/list', [CandidateController::class, 'index'])->name('candidate.index')->middleware(['can:candidate-read']);
    Route::get('/candidate/list/{demand_code}', [CandidateController::class, 'demandCandidates'])->name('candidate.demandCandidates')->middleware(['can:candidate-read']);
    Route::get('/candidate/approved/list/{demand_code}', [CandidateController::class, 'approvedDemandCandidates'])->name('approved.candidate.demandCandidates')->middleware(['can:candidate-read']);

    Route::get('/candidate/interview/list/{demand_code}', [CandidateController::class, 'interviewDemandCandidates'])->name('interview.candidate.demandCandidates')->middleware(['can:candidate-read']);
    Route::get('/candidate/create', [CandidateController::class, 'create'])->name('candidate.create')->middleware(['can:candidate-create']);
    Route::post('/candidate/store', [CandidateController::class, 'store'])->name('candidate.store')->middleware(['can:candidate-create']);
    Route::get('/candidate/edit/{id}', [CandidateController::class, 'edit'])->name('candidate.edit')->middleware(['can:candidate-update']);
    Route::put('/candidate/update/{id}', [CandidateController::class, 'update'])->name('candidate.update')->middleware(['can:candidate-update']);
    Route::get('/candidate/listCompanyDemands/{id}', [CandidateController::class, 'listCompanyDemands'])->name('candidate.listCompanyDemands');
    Route::get('/candidate/printCandidateApplication/{id}', [CandidateController::class, 'printCandidateApplication'])->name('candidate.printCandidateApplication');
    Route::get('/candidate/printNameCard/{ref_id}', [CandidateController::class, 'printNameCard'])->name('candidate.printNameCard')->middleware(['can:candidate-read']);
    Route::get('/candidate/deleteCandidate/{id}', [CandidateController::class, 'deleteCandidate'])->name('candidate.deleteCandidate')->middleware(['can:candidate-update']);
    Route::get('/candidate/details/{id}', [CandidateController::class, 'detail'])->name('candidate.detail')->middleware(['can:candidate-read']);
    Route::get('/details/{id}/{demandId}', [CandidateController::class, 'userDetail'])->name('user.detail')->middleware(['can:candidate-read']);

    Route::get('/details/{id}', [CandidateController::class, 'userDetails'])->name('user.details')->middleware(['can:candidate-read']);
    Route::get('/document/viewAdditionalDocuments/{candidate_id}', [CandidateController::class, 'viewAdditionalDocuments'])->name('document-process.viewAdditionalDocuments');


    Route::get('/manager/candidate/approved/list/{demand_code}', [CandidateController::class, 'managerApprovedDemandCandidates'])->name('manager.approved.candidate.demandCandidates');
    Route::get('/manager/candidate/interview/list/{demand_code}', [CandidateController::class, 'managerInterviewDemandCandidates'])->name('manager.interview.candidate.demandCandidates');


    Route::get('/receptionist/candidate/selected/list/{demand_code}', [CandidateController::class, 'receptionistSelectedCandidates'])->name('receptionist.selected.candidates');
    //Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index')->middleware(['can:webContent-read']);
    Route::get('/categories/add', [CategoryController::class, 'create'])->name('categories.create')->middleware(['can:webContent-create']);
    Route::post('/categories/add', [CategoryController::class, 'store'])->name('categories.store')->middleware(['can:webContent-create']);
    Route::get('/categories/edit/{slug}', [CategoryController::class, 'edit'])->name('categories.edit')->middleware(['can:webContent-update']);
    Route::put('/categories/update/{slug}', [CategoryController::class, 'update'])->name('categories.update')->middleware(['can:webContent-update']);
    Route::get('/categories/delete/{categoriesId}', [CategoryController::class, 'delete'])->name('categories.delete')->middleware(['can:webContent-delete']);

    //Education Types
    Route::get('/education/types', [EducationTypeController::class, 'index'])->name('education.types.index')->middleware(['can:webContent-read']);
    Route::get('/education/type/add', [EducationTypeController::class, 'create'])->name('education.types.create')->middleware(['can:webContent-create']);
    Route::post('/education/type/add', [EducationTypeController::class, 'store'])->name('education.types.store')->middleware(['can:webContent-create']);
    Route::get('/education/type/edit/{slug}', [EducationTypeController::class, 'edit'])->name('education.types.edit')->middleware(['can:webContent-update']);
    Route::put('/education/type/update/{slug}', [EducationTypeController::class, 'update'])->name('education.types.update')->middleware(['can:webContent-update']);
    Route::get('/education/type/delete/{educationId}', [EducationTypeController::class, 'delete'])->name('education.types.delete')->middleware(['can:webContent-delete']);

    //Language Types
    Route::get('/languages', [LanguageController::class, 'index'])->name('language.index')->middleware(['can:webContent-read']);
    Route::get('/language/add', [LanguageController::class, 'create'])->name('language.create')->middleware(['can:webContent-create']);
    Route::post('/language/add', [LanguageController::class, 'store'])->name('language.store')->middleware(['can:webContent-create']);
    Route::get('/language/edit/{slug}', [LanguageController::class, 'edit'])->name('language.edit')->middleware(['can:webContent-update']);
    Route::put('/language/update/{slug}', [LanguageController::class, 'update'])->name('language.update')->middleware(['can:webContent-update']);
    Route::get('/language/delete/{languageId}', [LanguageController::class, 'delete'])->name('language.delete')->middleware(['can:webContent-delete']);


    //Gender Types
    Route::get('/genders', [GenderController::class, 'index'])->name('gender.index')->middleware(['can:webContent-read']);
    Route::get('/gender/add', [GenderController::class, 'create'])->name('gender.create')->middleware(['can:webContent-create']);
    Route::post('/gender/add', [GenderController::class, 'store'])->name('gender.store')->middleware(['can:webContent-create']);
    Route::get('/gender/edit/{slug}', [GenderController::class, 'edit'])->name('gender.edit')->middleware(['can:webContent-update']);
    Route::put('/gender/update/{slug}', [GenderController::class, 'update'])->name('gender.update')->middleware(['can:webContent-update']);
    Route::get('/gender/delete/{genderId}', [GenderController::class, 'delete'])->name('gender.delete')->middleware(['can:webContent-delete']);

    //Year Types
    Route::get('/years', [YearController::class, 'index'])->name('year.index')->middleware(['can:webContent-read']);
    Route::get('/year/add', [YearController::class, 'create'])->name('year.create')->middleware(['can:webContent-create']);
    Route::post('/year/add', [YearController::class, 'store'])->name('year.store')->middleware(['can:webContent-create']);
    Route::get('/year/edit/{slug}', [YearController::class, 'edit'])->name('year.edit')->middleware(['can:webContent-update']);
    Route::put('/year/update/{slug}', [YearController::class, 'update'])->name('year.update')->middleware(['can:webContent-update']);
    Route::get('/year/delete/{yearId}', [YearController::class, 'delete'])->name('year.delete')->middleware(['can:webContent-delete']);


});



//profile route
Route::middleware(['auth:web'])->prefix('/user/profile')->group(function(){

    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/updateProfile', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
    Route::post('/uploadProfile', [ProfileController::class, 'uploadProfile'])->name('profile.uploadProfile');
});

//website routes
Route::middleware(['auth:web'])->prefix('/user/website')->group(function(){

    //site settings
    Route::get('/settings', [SiteSettingController::class, 'index'])->name('website.settings')->middleware(['can:webContent-read']);
    Route::post('/settings/store', [SiteSettingController::class, 'store'])->name('website.settings.store')->middleware(['can:webContent-create']);

    //sliders
    Route::get('/sliders', [SliderController::class, 'index'])->name('website.slider.index')->middleware(['can:webContent-read']);
    Route::get('/slider/add', [SliderController::class, 'add'])->name('website.slider.add')->middleware(['can:webContent-create']);
    Route::get('/slider/edit/{id}', [SliderController::class, 'edit'])->name('website.slider.edit')->middleware(['can:webContent-update']);
    Route::put('/slider/update/{id}', [SliderController::class, 'update'])->name('website.slider.update')->middleware(['can:webContent-update']);
    Route::get('/slider/delete/{id}', [SliderController::class, 'delete'])->name('website.slider.delete')->middleware(['can:webContent-delete']);
    Route::post('/slider/store', [SliderController::class, 'store'])->name('website.slider.store')->middleware(['can:webContent-create']);


    //splash screen
    Route::get('/splash', [SplashController::class, 'index'])->name('website.splash.index')->middleware(['can:webContent-read']);
    Route::get('/splash/add', [SplashController::class, 'add'])->name('website.splash.add')->middleware(['can:webContent-create']);
    Route::get('/splash/edit/{id}', [SplashController::class, 'edit'])->name('website.splash.edit')->middleware(['can:webContent-update']);
    Route::put('/splash/update/{id}', [SplashController::class, 'update'])->name('website.splash.update')->middleware(['can:webContent-update']);
    Route::get('/splash/delete/{id}', [SplashController::class, 'delete'])->name('website.splash.delete')->middleware(['can:webContent-delete']);
    Route::post('/splash/store', [SplashController::class, 'store'])->name('website.splash.store')->middleware(['can:webContent-create']);


    //services
    Route::get('/services', [ServiceController::class, 'index'])->name('website.services.index')->middleware(['can:webContent-read']);
    Route::get('/service/create', [ServiceController::class, 'create'])->name('website.services.create')->middleware(['can:webContent-create']);
    Route::post('/service/store', [ServiceController::class, 'store'])->name('website.services.store')->middleware(['can:webContent-create']);
    Route::get('/service/edit/{id}', [ServiceController::class, 'edit'])->name('website.services.edit')->middleware(['can:webContent-update']);
    Route::put('/service/update/{id}', [ServiceController::class, 'update'])->name('website.services.update')->middleware(['can:webContent-update']);
    Route::get('/service/delete/{id}', [ServiceController::class, 'delete'])->name('website.services.delete')->middleware(['can:webContent-delete']);

    //portfolio
    Route::get('/portfolios', [PortfolioController::class, 'index'])->name('website.portfolio.index')->middleware(['can:webContent-read']);
    Route::get('/portfolio/create', [PortfolioController::class, 'create'])->name('website.portfolio.create')->middleware(['can:webContent-create']);
    Route::post('/portfolio/store', [PortfolioController::class, 'store'])->name('website.portfolio.store')->middleware(['can:webContent-create']);
    Route::get('/portfolio/delete/{id}', [PortfolioController::class, 'delete'])->name('website.portfolio.delete')->middleware(['can:webContent-delete']);

    //message from chairman
    Route::get('/chairman/message', [WebcontentController::class, 'messageFromChairman'])->name('website.messageFromChairman')->middleware(['can:webContent-create']);
    Route::post('/chairman/message', [WebcontentController::class, 'storeChairmanMessage'])->name('website.storeChairmanMessage')->middleware(['can:webContent-create']);
    Route::get('/about-us', [WebcontentController::class, 'aboutUsPage'])->name('website.aboutUsPage')->middleware(['can:webContent-create']);
    Route::post('/about-us', [WebcontentController::class, 'storeAboutUs'])->name('website.storeAboutUs')->middleware(['can:webContent-create']);

    //gallery routes
    Route::get('/gallery/categories', [GalleryController::class, 'index'])->name('website.gallery.category.index')->middleware(['can:webContent-read']);
    Route::get('/gallery/add/category', [GalleryController::class, 'createCategory'])->name('website.gallery.category.create')->middleware(['can:webContent-create']);
    Route::get('/gallery/edit/category/{slug}', [GalleryController::class, 'editCategory'])->name('website.gallery.category.edit')->middleware(['can:webContent-update']);
    Route::put('/gallery/edit/category/updateCategory/{catId}', [GalleryController::class, 'updateCategory'])->name('website.gallery.category.updateCategory')->middleware(['can:webContent-update']);
    Route::post('/gallery/store/category', [GalleryController::class, 'storeCategory'])->name('website.gallery.category.store')->middleware(['can:webContent-create']);
    Route::get('/gallery/category/toggleCategoryStatus/{cat_id}', [GalleryController::class, 'toggleCategoryStatus'])->name('website.gallery.category.toggleCategoryStatus')->middleware(['can:webContent-update']);
    Route::get('/gallery/category/deleteCategory/{cat_id}', [GalleryController::class, 'deleteCategory'])->name('website.gallery.category.deleteCategory')->middleware(['can:webContent-delete']);

    //images
    Route::get('/gallery/image/categories', [GalleryController::class, 'imageSection'])->name('website.gallery.images.imageSection')->middleware(['can:webContent-read']);
    Route::get('/gallery/{slug}/images', [GalleryController::class, 'imageUploadPage'])->name('website.gallery.images.imageUploadPage')->middleware(['can:webContent-create']);
    Route::get('/gallery/images/{catId}/list', [GalleryController::class, 'getImages'])->name('website.gallery.images.getImages')->middleware(['can:webContent-read']);
    Route::post('/gallery/images/upload/{cat_id}', [GalleryController::class, 'store'])->name('website.gallery.images.store')->middleware(['can:webContent-create']);
    Route::post('/gallery/image/delete', [GalleryController::class, 'destroy'])->name('website.gallery.images.destroy')->middleware(['can:webContent-delete']);

    //news
    Route::get('/news', [NewsController::class, 'index'])->name('website.news.index')->middleware(['can:webContent-read']);
    Route::get('/news/add', [NewsController::class, 'create'])->name('website.news.create')->middleware(['can:webContent-create']);
    Route::post('/news/add', [NewsController::class, 'store'])->name('website.news.store')->middleware(['can:webContent-create']);
    Route::get('/news/edit/{slug}', [NewsController::class, 'edit'])->name('website.news.edit')->middleware(['can:webContent-update']);
    Route::put('/news/update/{slug}', [NewsController::class, 'update'])->name('website.news.update')->middleware(['can:webContent-update']);
    Route::get('/news/delete/{newsId}', [NewsController::class, 'delete'])->name('website.news.delete')->middleware(['can:webContent-delete']);
});


//master search
Route::get('/master-search', [MasterSearchController::class, 'index'])->name('master.index');
Route::get('/master-search/candidate/', [MasterSearchController::class, 'search'])->name('master.search');


Route::middleware(['auth:web'])->prefix('/user/testimonials')->group(function(){

    Route::get('/list', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::get('/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/store', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('/edit/{id}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
    Route::put('/update/{id}', [TestimonialController::class, 'update'])->name('testimonial.update');
    Route::get('/delete/{id}', [TestimonialController::class, 'delete'])->name('testimonial.delete');
});











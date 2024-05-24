<?php

namespace App\Http\Controllers\Frontend;

use App\Data\company\CompanyData;
use App\Data\CompanyDemand\CompanyDemandData;
use App\Enum\InterviewStatus;
use App\Http\Controllers\Controller;
use App\Models\CompanyDemand;
use App\Models\GalleryCategory;
use App\Models\GalleryImages;
use App\Models\News;
use App\Models\Portfolio;
use App\Models\Services;
use App\Models\Sliders;
use App\Models\Testimonials;
use Illuminate\Http\Request;

class PageController extends Controller
{


    public function index(){

        $sliders = Sliders::all();
        $services = Services::limit(6)->get();
        $workingCompanies = (new CompanyData())->companyList();
        $testimonials = Testimonials::limit(6)->orderBy('created_at', 'desc')->get();
        $medias = GalleryImages::orderBy('created_at', 'desc')->limit(10)->get();
        $latestNews = News::latest()->first();
        return view('frontend.pages.home', compact('sliders', 'services', 'medias', 'workingCompanies', 'testimonials', 'latestNews'));

    }

    public function singleService($slug){

        $service = Services::where('slug', $slug)->first();

        $otherServices = Services::where('id', '!=', $service->id)->inRandomOrder()->limit(6)->get();

        return view('frontend.pages.single-service', compact('service', 'otherServices'));
    }

    public function aboutUs(){
        return view('frontend.pages.about');
    }

    public function services(){
        return view('frontend.pages.services');
    }

    public function contactUs(){
        return view('frontend.pages.contact');
    }

    public function privacyPolicy(){
        return view('frontend.pages.general-page');
    }

    public function vaccancy(){
        $demands = CompanyDemand::orderBy('created_at', 'desc')->get();
        $availableDemands = collect($demands)->map(function($row){
            $candidates = CompanyDemand::join('candidates', 'company_demands.id', '=', 'candidates.demand_id')
                ->join('interviews', 'candidates.id', '=', 'interviews.candidate_id')
                ->where('company_demands.id', '=', $row->id)
                ->where('interviews.status', '=', InterviewStatus::APPROVED)
                ->count();
            if($candidates > 0){
                return null;
            }else{
                return $row;
            }    
        })->whereNotNull();
        return view('frontend.pages.vaccancy', compact('availableDemands'));
    }

    public function news(){
        $news = News::orderBy('created_at', 'desc')->get();
        return view('frontend.pages.news', compact('news'));
    }

    public function newsDetails($slug){
        $singleNews = News::where('slug', $slug)->first();
        $relatedNews = News::where('id', '!=', $singleNews->id)->limit(5)->inRandomOrder()->get();
        return view('frontend.pages.news-details', compact('singleNews', 'relatedNews'));
    }

    public function gallery(){
        $galleryCategories = GalleryCategory::where('active_status', true)->orderBy('category_name', 'asc')->get();
        return view('frontend.pages.gallery', compact('galleryCategories'));
    }

    public function galleryDetails($slug){
        $galleryCategory = GalleryCategory::where('slug', $slug)->first();
        return view('frontend.pages.gallery-details', compact('galleryCategory'));
    }

    public function termsAndConditions(){
        return view('frontend.pages.terms-condition');
    }

    public function recruitment(){
        return view('frontend.pages.recruitment');
    }

    public function demandDetails($demandCode){
        $demand = (new CompanyDemandData())->getDemandViaCode($demandCode);
        return view('frontend.pages.demand-details', compact('demand'));
    }
}

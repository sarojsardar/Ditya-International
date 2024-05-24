<?php

namespace App\Http\Controllers\Backend;

use App\Models\WebContent;
use Illuminate\Http\Request;
use App\Helper\ImageUploadHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class WebcontentController extends Controller
{
    public function messageFromChairman(){
        $webContent = WebContent::first();
        return view('backend.website.message.message', compact('webContent'));   
    }

    public function storeChairmanMessage(Request $request){

        $chairmanImage = '';
        $webContent = WebContent::first();

        DB::beginTransaction();
        try{
            if(!$webContent){

                $webContent = new WebContent();
    
                if($request->hasFile('profile')){
                    $file = $request->file('profile');
                    $chairmanImage = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/chairman-image', 'chairman');
                }else{
                    $chairmanImage = @$webContent->chairmanImage;
                }
                    $webContent->chairman_profile = $chairmanImage;
                    $webContent->chairman_name = $request->chairman_name;
                    $webContent->chairman_message = $request->chairman_message;
                    $webContent->save();

                    DB::commit();
                    return back()->with('success', 'Record updated successfully');
            }else{

                if($request->hasFile('profile')){
                    $file = $request->file('profile');
                    $chairmanImage = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/chairman-image', 'chairman');
                }else{
                    $chairmanImage = @$webContent->chairmanImage;
                }

                $webContent->chairman_profile = $chairmanImage;
                $webContent->chairman_name = $request->chairman_name;
                $webContent->chairman_message = $request->chairman_message;
                $webContent->save();

                DB::commit();
                return back()->with('success', 'Record updated successfully');
            }
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Something went wrong');
        }        
    }

    public function aboutUsPage(){
        return view('backend.website.pages.about');
    }

    public function storeAboutUs(Request $request){

        $about_us_banner = '';
        $about_us_side_banner = '';

        $webContent = WebContent::first();

        DB::beginTransaction();
        try{

            if(!$webContent){
                if($request->hasFile('about_us_banner')){
                    $file = $request->file('about_us_banner');
                    $originalName = $file->getClientOriginalName();
                    $originalName = pathinfo($originalName, PATHINFO_FILENAME);

                    dd($originalName);
                    $about_us_banner = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/web-images', $originalName);
                }else{
                    $about_us_banner = @$webContent->about_us_banner;
                }
                if($request->hasFile('about_us_side_banner')){
                    $file = $request->file('about_us_side_banner');
                    $originalName = $file->getClientOriginalName();
                    $originalName = pathinfo($originalName, PATHINFO_FILENAME);
                    $about_us_side_banner = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/web-images', $originalName);
                }else{
                    $about_us_side_banner = @$webContent->about_us_side_banner;
                }
    
                $webContent = new WebContent();
                $webContent->about_us_title = $request->about_us_title;
                $webContent->about_us_banner = $request->about_us_banner;
                $webContent->about_us_side_banner = $request->about_us_side_banner;
                $webContent->about_us_content = $request->about_us_content;
                $webContent->save();
            }else{
                if($request->hasFile('about_us_banner')){
                    $file = $request->file('about_us_banner');
                    $originalName = $file->getClientOriginalName();
                    $originalName = pathinfo($originalName, PATHINFO_FILENAME);
                    $about_us_banner = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/web-images', $originalName);
                }else{
                    $about_us_banner = @$webContent->about_us_banner;
                }
                if($request->hasFile('about_us_side_banner')){
                    $file = $request->file('about_us_side_banner');
                    $originalName = $file->getClientOriginalName();
                    $originalName = pathinfo($originalName, PATHINFO_FILENAME);
                    $about_us_side_banner = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/web-images', $originalName);
                }else{
                    $about_us_side_banner = @$webContent->about_us_side_banner;
                }
    
                $webContent->about_us_title = $request->about_us_title;
                $webContent->about_us_banner = $about_us_banner;
                $webContent->about_us_side_banner = $about_us_side_banner;
                $webContent->about_us_content = $request->about_us_content;
                $webContent->save();
            }

            DB::commit();
            return back()->with('success', 'Record updated successfully');

        }catch(\Exception $e){
            DB::rollBack();
            dd($e);
            return back()->with('error', 'Something went wrong');
        }
    }


}

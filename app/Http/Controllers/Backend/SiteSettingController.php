<?php

namespace App\Http\Controllers\Backend;

use App\Helper\ImageUploadHelper;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SiteSettingController extends Controller
{

    public function index(){
        $currentSetting = SiteSetting::first();
        return view('backend.website.setting.index', compact('currentSetting'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'site_logo' => 'sometimes|required|mimes:jpg,jpeg,png,bmp,tiff|max:4096',
            'site_logo_sm' => 'sometimes|required|image|mimes:jpg,jpeg,png,gif|max:4048',
            // Include validations for other fields as necessary
        ]);

        DB::beginTransaction();

        try {
            $currentSetting = SiteSetting::firstOrNew([]);

            if ($request->hasFile('site_logo')) {
                $file = $request->file('site_logo');
                $currentSetting->site_logo = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/site-logo', 'logo');
            }

            if ($request->hasFile('site_logo_sm')) {
                $file = $request->file('site_logo_sm');
                $currentSetting->site_logo_sm = (new ImageUploadHelper())->uploadImage($file, 'public/uploads/site-logo-sm', 'logo-sm');
            }

            // Using null coalescing operator to avoid overriding with null if not provided
            $currentSetting->site_name = $request->site_name ?? $currentSetting->site_name;
            $currentSetting->map = $request->map ?? $currentSetting->map;
            $currentSetting->description = $request->description ?? $currentSetting->description;
            $currentSetting->terms_and_condition = $request->terms_and_condition ?? $currentSetting->terms_and_condition;
            $currentSetting->contact = $request->contact ?? $currentSetting->contact;
            $currentSetting->official_email = $request->official_email ?? $currentSetting->official_email;
            $currentSetting->fb_link = $request->fb_link ?? $currentSetting->fb_link;
            $currentSetting->insta_link = $request->insta_link ?? $currentSetting->insta_link;
            $currentSetting->location = $request->location ?? $currentSetting->location;
            $currentSetting->tiktok_link = $request->tiktok_link ?? $currentSetting->tiktok_link;
            $currentSetting->whatsapp = $request->whatsapp ?? $currentSetting->whatsapp;
            $currentSetting->privacy_and_policy = $request->privacy_and_policy ?? $currentSetting->privacy_and_policy;

            $currentSetting->save();

            DB::commit();
            return back()->with('success', 'Settings updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

}

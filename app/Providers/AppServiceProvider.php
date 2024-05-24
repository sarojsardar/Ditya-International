<?php

namespace App\Providers;

use App\Models\Services;
use App\Models\SiteSetting;
use App\Models\WebContent;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $setting = SiteSetting::first();
        $webContent = WebContent::first();
        $services = Services::all();
        View::share('setting', $setting);
        View::share('webContent', $webContent);
        View::share('services', $services);
        Paginator::useBootstrap();

    }
}

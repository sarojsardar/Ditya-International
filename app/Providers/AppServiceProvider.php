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
        View::composer('*', function($view){
            $setting = SiteSetting::first();
            $webContent = WebContent::first();
            $services = Services::all();
            $view->with('setting', $setting);
            $view->with('webContent', $webContent);
            $view->with('services', $services);
            $view->with('setting', $setting);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
    }
}

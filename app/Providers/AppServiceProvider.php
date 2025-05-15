<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Branch;
use Illuminate\Support\Facades\Cache;

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
        // Share categories and branches with all views
        View::composer('*', function ($view) {
            // Cache for better performance (60 minutes)
            $categories = Cache::remember('all_categories', 60*60, function () {
                return Category::all();
            });
            
            $branches = Cache::remember('all_branches', 60*60, function () {
                return Branch::all();
            });
            
            $view->with('categories', $categories);
            $view->with('branches', $branches);
        });
    }
}
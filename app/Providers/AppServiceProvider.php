<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Branch;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Migrations\Migrator;

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
            // Reduce cache time to 5 minutes
            $categories = Cache::remember('all_categories', 5 * 60, function () {
                return Category::all();
            });

            $branches = Cache::remember('all_branches', 5 * 60, function () {
                return Branch::all();
            });

            $view->with('categories', $categories);
            $view->with('branches', $branches);
        });
    }
}
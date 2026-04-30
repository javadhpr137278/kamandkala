<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
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
        View::composer('admin.layouts.navigation', function ($view) {
            $view->with('users', User::all());
        });
        View::composer('*', function ($view) {
            $categories = Category::with('childCategory.childCategory')
                ->where('parent_id', 0)
                ->get();

            $view->with('categories', $categories);
        });

        Blade::directive('isChildOf', function ($expression) {
            return "<?php echo isChildOf($expression); ?>";
        });

    }
}

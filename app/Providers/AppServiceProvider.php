<?php






/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use App\Helpers\ThemeHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        View::composer('hrace009::language-button', function ($view) {
            $languageFiles = File::directories(resource_path('lang'));
            $languages = array_map('basename', $languageFiles);
            $view->with('languages', $languages);
        });
        
        // Make theme helper available to all views
        View::share('themeHelper', new ThemeHelper());
    }
}

<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        (new \App\Taxonomies\SpecialityType())->register();
        (new \App\Services\DoctorSpecialitySync())->register();
        (new \App\Services\DoctorApi())->register();
        (new \App\Services\PostApi())->register();
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\PopulateTestimonials::class,
                \App\Console\Commands\PopulateFAQ::class,
            ]);
        }
    }
}

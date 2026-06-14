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
        (new \App\Api\DoctorApi())->register();
        (new \App\Api\PostApi())->register();
        (new \App\Api\AvailabilityApi())->register();
        (new \App\Api\AppointmentsApi())->register();
        (new \App\Admin\ClientDashboard())->register();
        (new \App\Services\Appointments\AppointmentFormListener())->register();
        if ($this->app->runningInConsole()) {
            $this->commands([
                \App\Console\Commands\PopulateTestimonials::class,
                \App\Console\Commands\PopulateFAQ::class,
            ]);
        }
    }
}

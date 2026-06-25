<?php

namespace App\Providers;

use App\Admin\ClientDashboard;
use App\Api\AppointmentsApi;
use App\Api\AvailabilityApi;
use App\Api\DoctorApi;
use App\Api\PostApi;
use App\Console\Commands\PopulateFAQ;
use App\Console\Commands\PopulateTestimonials;
use App\Services\Appointments\AppointmentFormListener;
use App\Services\DoctorSpecialitySync;
use App\Services\SchemaService;
use App\Taxonomies\SpecialityType;
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
        (new SpecialityType)->register();
        (new DoctorSpecialitySync)->register();
        (new DoctorApi)->register();
        (new PostApi)->register();
        (new AvailabilityApi)->register();
        (new AppointmentsApi)->register();
        (new ClientDashboard)->register();
        (new AppointmentFormListener)->register();
        (new SchemaService)->register();
        if ($this->app->runningInConsole()) {
            $this->commands([
                PopulateTestimonials::class,
                PopulateFAQ::class,
            ]);
        }
    }
}

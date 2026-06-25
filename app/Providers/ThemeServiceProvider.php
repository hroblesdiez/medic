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

        add_action('wp_head', function () {
            if (is_admin()) {
                return;
            }

            $description = '';

            if (is_front_page()) {
                $description = carbon_get_theme_option('medic_seo_description')
                    ?: 'Medicall — Professional medical clinic in Warsaw. Book appointments with trusted specialists for personalized healthcare.';
            } elseif (is_singular('doctors')) {
                $doctorId = get_the_ID();
                $customDesc = carbon_get_post_meta($doctorId, 'doctor_seo_description');
                $description = ! empty($customDesc)
                    ? $customDesc
                    : wp_trim_words(wp_strip_all_tags(carbon_get_post_meta($doctorId, 'doctor_bio') ?: ''), 30);
            } elseif (is_singular() && ! class_exists('RankMath\\Post')) {
                $post = get_post();
                if ($post) {
                    $description = ! empty($post->post_excerpt)
                        ? $post->post_excerpt
                        : wp_trim_words(wp_strip_all_tags($post->post_content), 30);
                }
            }

            if (! empty($description)) {
                echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
            }
        }, 20);

        if ($this->app->runningInConsole()) {
            $this->commands([
                PopulateTestimonials::class,
                PopulateFAQ::class,
            ]);
        }
    }
}

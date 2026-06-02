<?php

use App\Providers\ThemeServiceProvider;
use Roots\Acorn\Application;

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (! file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}
error_log('🔥 FUNCTIONS.PHP LOADED');
require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

Application::configure()
    ->withProviders([
        ThemeServiceProvider::class,
    ])
    ->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters', 'Fields/OptionsPage', 'Fields/SpecialityFields', 'Fields/DoctorsFields', 'Fields/TestimonialsFields'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });

add_action('save_post_doctor', function ($post_id) {

    $speciality = get_post_meta($post_id, 'speciality', true);

    if (!$speciality) return;

    $term = get_term_by('slug', $speciality, 'speciality_type');

    if (!$term) return;

    wp_set_object_terms(
        $post_id,
        [$term->term_id],
        'speciality_type',
        false
    );
});

// add_action('wp_loaded', function () {

//     error_log('🚀 SYNC STARTED');

//     $doctors = get_posts([
//         'post_type' => 'doctors',
//         'numberposts' => -1,
//         'post_status' => 'publish',
//     ]);

//     error_log('📦 DOCTORS FOUND: ' . count($doctors));

//     if (empty($doctors)) {
//         error_log('❌ NO DOCTORS FOUND');
//         return;
//     }

//     foreach ($doctors as $doctor) {

//         error_log("➡️ Doctor ID: {$doctor->ID}");

//         if (!function_exists('carbon_get_post_meta')) {
//             error_log('❌ Carbon not available');
//             return;
//         }

//         $speciality_slug = carbon_get_post_meta($doctor->ID, 'doctor_speciality');

//         error_log("📌 META VALUE: " . print_r($speciality_slug, true));

//         if (!$speciality_slug) {
//             error_log("⚠️ EMPTY SPECIALITY for {$doctor->ID}");
//             continue;
//         }

//         $term = get_term_by('slug', $speciality_slug, 'speciality_type');

//         if (!$term) {
//             error_log("❌ TERM NOT FOUND: {$speciality_slug}");
//             continue;
//         }

//         $result = wp_set_object_terms(
//             $doctor->ID,
//             [$term->term_id],
//             'speciality_type',
//             false
//         );

//         if (is_wp_error($result)) {
//             error_log("❌ ERROR assigning doctor {$doctor->ID}");
//         } else {
//             error_log("✅ ASSIGNED doctor {$doctor->ID} → {$speciality_slug}");
//         }
//     }
// }, 20);

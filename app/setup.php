<?php

/**
 * Theme setup.
 */

namespace App;

use Illuminate\Support\Facades\Vite;
use App\PostTypes\Speciality;
use App\PostTypes\Doctors;
use App\PostTypes\Testimonials;
use App\PostTypes\FAQ;
use App\Fields\OptionsPage;
use App\Fields\SpecialityFields;
use App\Fields\DoctorsFields;
use App\Fields\TestimonialsFields;
use App\Fields\FAQFields;
use App\Taxonomies\SpecialityType;


/**
 * Inject styles into the block editor.
 *
 * @return array
 */
add_filter('block_editor_settings_all', function ($settings) {
    $style = Vite::asset('resources/css/editor.css');

    $settings['styles'][] = [
        'css' => "@import url('{$style}')",
    ];

    return $settings;
});

/**
 * Inject scripts into the block editor.
 *
 * @return void
 */
add_action('admin_head', function () {
    if (! get_current_screen()?->is_block_editor()) {
        return;
    }

    if (! Vite::isRunningHot()) {
        $dependencies = json_decode(Vite::content('editor.deps.json'));

        foreach ($dependencies as $dependency) {
            if (! wp_script_is($dependency)) {
                wp_enqueue_script($dependency);
            }
        }
    }
    echo Vite::withEntryPoints([
        'resources/js/editor.js',
    ])->toHtml();
});

/**
 * Use the generated theme.json file.
 *
 * @return string
 */
add_filter('theme_file_path', function ($path, $file) {
    return $file === 'theme.json'
        ? public_path('build/assets/theme.json')
        : $path;
}, 10, 2);

/**
 * Disable on-demand block asset loading.
 *
 * @link https://core.trac.wordpress.org/ticket/61965
 */
add_filter('should_load_separate_core_block_assets', '__return_false');

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     *
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage'),
        'footer_company' => __('Footer Company', 'sage'),
        'footer_utilities' => __('Footer Utilities', 'sage'),
        'footer_specialities' => __('Footer Specialities', 'sage'),
        'footer_treatments' => __('Footer Treatments', 'sage'),
    ]);

    /**
     * Disable the default block patterns.
     *
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable responsive embed support.
     *
     * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style',
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     *
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#customize-selective-refresh-widgets
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Register Custom Post Types
     *
     * @link https://developer.wordpress.org/reference/functions/register_post_type/
     */
    (new Speciality())->register();
    (new Doctors())->register();
    (new Testimonials())->register();
    (new FAQ())->register();
    (new SpecialityType)->register();
}, 20);

/**
 * Register Carbon Fields.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    try {
        if (class_exists('\Carbon_Fields\Carbon_Fields')) {
            \Carbon_Fields\Carbon_Fields::boot();
        }
    } catch (\Exception $e) {
        error_log('Medic Theme - Carbon Fields Boot Error: ' . $e->getMessage());
    }
}, 2);

/**
 * Register the fields.
 *
 * @return void
 */
add_action('carbon_fields_register_fields', function () {

    (new OptionsPage())->register();
    (new SpecialityFields())->register();
    (new DoctorsFields())->register();
    (new TestimonialsFields())->register();
    (new FAQFields())->register();
});

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary',
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer',
    ] + $config);
});


add_action('carbon_fields_theme_options_container_saved', function () {
    try {
        // Ruta a la caché de vistas de Sage
        $storage_path = get_template_directory() . '/storage/framework/views';

        if (is_dir($storage_path)) {
            $files = glob($storage_path . '/*.php');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Borramos físicamente cada archivo de caché
                }
            }
            error_log("Medic Debug: Caché de vistas limpiada correctamente tras guardar.");
        }
    } catch (\Exception $e) {
        error_log("Medic Error limpiando caché: " . $e->getMessage());
    }
});

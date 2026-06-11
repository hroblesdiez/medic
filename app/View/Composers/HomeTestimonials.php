<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class HomeTestimonials extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.home.testimonials',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'testimonials' => $this->get_testimonials(),
        ];
    }

    /**
     * Get testimonials from the CPT.
     *
     * @return array
     */
    public function get_testimonials()
    {
        $args = [
            'post_type' => 'testimonial',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        $query = new WP_Query($args);

        $testimonials = [];

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                $image_id = carbon_get_post_meta($post->ID, 'testimonial_image');
                $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : get_the_post_thumbnail_url($post->ID, 'large');

                $testimonials[] = (object) [
                    'image' => $image_url,
                    'subtitle' => carbon_get_post_meta($post->ID, 'testimonial_subtitle'),
                    'title' => carbon_get_post_meta($post->ID, 'testimonial_title'),
                    'text' => carbon_get_post_meta($post->ID, 'testimonial_text'),
                    'name' => carbon_get_post_meta($post->ID, 'testimonial_name'),
                    'city' => carbon_get_post_meta($post->ID, 'testimonial_city'),
                ];
            }
        }

        return $testimonials;
    }
}

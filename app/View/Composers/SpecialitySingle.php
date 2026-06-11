<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class SpecialitySingle extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single-speciality',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'top_doctors' => $this->getTopDoctors(),
        ];
    }

    /**
     * Get 4 most experienced doctors for the current speciality.
     *
     * @return array
     */
    public function getTopDoctors()
    {
        $post = get_post();
        if (!$post) {
            return [];
        }

        // Match the speciality slug with the taxonomy term
        $args = [
            'post_type' => 'doctors',
            'posts_per_page' => 4,
            'post_status' => 'publish',
            'meta_key' => '_doctor_years_experience',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'tax_query' => [
                [
                    'taxonomy' => 'speciality_type',
                    'field' => 'slug',
                    'terms' => $post->post_name,
                ],
            ],
        ];

        // Let's verify if Carbon Fields uses '_' prefix for meta keys in WP_Query.
        // Usually it's '_' + field_name.
        
        $query = new WP_Query($args);

        return $query->posts;
    }
}

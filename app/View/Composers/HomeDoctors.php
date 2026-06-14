<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class HomeDoctors extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.home.best-doctors',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $service = new \App\Services\Doctors\DoctorService();
        $doctors = $this->get_best_doctors();

        return [
            'doctors' => array_map(fn($doctor) => $service->getDoctorData($doctor), $doctors),
        ];
    }

    /**
     * Get 4 random doctors from the CPT.
     *
     * @return array
     */
    public function get_best_doctors()
    {
        $args = [
            'post_type' => 'doctors',
            'posts_per_page' => 4,
            'orderby' => 'rand',
            'post_status' => 'publish',
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => '_exclude_from_grid',
                    'value' => 'yes',
                    'compare' => '!=',
                ],
                [
                    'key' => '_exclude_from_grid',
                    'compare' => 'NOT EXISTS',
                ],
            ],
        ];

        $query = new WP_Query($args);

        // Devolvemos directamente el array de objetos WP_Post
        return $query->posts;
    }
}

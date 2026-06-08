<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class AppointmentsPage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'page-appointments',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'specialists' => $this->get_specialists(),
        ];
    }

    /**
     * Get the 4 specialists.
     *
     * @return array
     */
    public function get_specialists()
    {
        $args = [
            'post_type' => 'doctors',
            'posts_per_page' => 4,
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => '_exclude_from_grid',
                    'value' => 'yes',
                    'compare' => '=',
                ],
            ],
            'orderby' => 'ID',
            'order' => 'ASC',
        ];

        $query = new WP_Query($args);

        return $query->posts;
    }
}

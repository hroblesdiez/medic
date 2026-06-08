<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class DoctorsArchive extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'archive-doctors',
        'taxonomy-speciality_type',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $doctors_query = $this->getDoctorsQuery();
        return [
            'doctors' => $doctors_query->posts,
            'max_pages' => $doctors_query->max_num_pages,
            'specialities' => $this->getSpecialities(),
            'max_price' => $this->getMaxPrice(),
            'current_speciality' => $this->getCurrentSpeciality(),
        ];
    }

    /**
     * Get doctors query.
     *
     * @return WP_Query
     */
    public function getDoctorsQuery()
    {
        $args = [
            'post_type' => 'doctors',
            'posts_per_page' => -1,
            'status' => 'publish',
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

        if (is_tax('speciality_type')) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'speciality_type',
                    'field' => 'slug',
                    'terms' => get_query_var('speciality_type'),
                ],
            ];
        }

        return new WP_Query($args);
    }

    /**
     * Get specialities.
     *
     * @return array
     */
    public function getSpecialities()
    {
        return get_terms([
            'taxonomy' => 'speciality_type',
            'hide_empty' => false,
        ]);
    }

    /**
     * Get max price for the range slider.
     *
     * @return int
     */
    public function getMaxPrice()
    {
        // For a real production app, we would query the DB for the max value.
        // For now, let's set a reasonable default or query it if possible.
        return 500;
    }

    /**
     * Get current speciality if on taxonomy page.
     *
     * @return int|null
     */
    public function getCurrentSpeciality()
    {
        if (is_tax('speciality_type')) {
            return get_queried_object_id();
        }

        return null;
    }
}

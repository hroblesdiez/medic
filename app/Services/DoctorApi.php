<?php

namespace App\Services;

use WP_Query;
use function Roots\view;

class DoctorApi
{
    public function register(): void
    {
        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    public function registerRoutes(): void
    {
        register_rest_route('medic/v1', '/doctors', [
            'methods' => 'GET',
            'callback' => [$this, 'filterDoctors'],
            'permission_callback' => function () {
                return true;
            },
        ]);
    }

    public function filterDoctors($request): \WP_REST_Response
    {
        try {
            $speciality = $request->get_param('speciality');
            $min_price = $request->get_param('min_price');
            $max_price = $request->get_param('max_price');
            $location = $request->get_param('location');
            $page = $request->get_param('page') ?: 1;

            $args = [
                'post_type' => 'doctors',
                'posts_per_page' => 12,
                'paged' => $page,
                'post_status' => 'publish',
                'meta_query' => [],
                'tax_query' => [],
            ];

            if (!empty($speciality)) {
                $args['tax_query'][] = [
                    'taxonomy' => 'speciality_type',
                    'field' => 'term_id',
                    'terms' => $speciality,
                ];
            }

            if (isset($min_price) || isset($max_price)) {
                $args['meta_query'][] = [
                    'key' => 'doctor_price',
                    'value' => [$min_price ?: 0, $max_price ?: 9999],
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                ];
            }

            if (!empty($location)) {
                $args['meta_query'][] = [
                    'key' => 'doctor_location',
                    'value' => $location,
                    'compare' => 'LIKE',
                ];
            }

            $query = new WP_Query($args);
            $html = '';

            if ($query->have_posts()) {
                foreach ($query->posts as $doctor) {
                    // Renderizamos cada tarjeta usando el componente centralizado
                    $html .= view('partials.doctor-card', ['doctor' => $doctor])->render();
                }
            }

            return new \WP_REST_Response([
                'html' => $html,
                'max_pages' => (int) $query->max_num_pages,
                'found_posts' => (int) $query->found_posts,
            ], 200);
        } catch (\Exception $e) {
            error_log('DoctorApi Error: ' . $e->getMessage());
            return new \WP_REST_Response(['message' => 'Error processing filters'], 500);
        }
    }
}

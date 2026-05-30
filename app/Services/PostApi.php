<?php

namespace App\Services;

use WP_Query;
use function Roots\view;

class PostApi
{
    public function register(): void
    {
        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    public function registerRoutes(): void
    {
        register_rest_route('medic/v1', '/posts', [
            'methods' => 'GET',
            'callback' => [$this, 'getPosts'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function getPosts($request): \WP_REST_Response
    {
        try {
            $page = $request->get_param('page') ?: 1;

            $args = [
                'post_type' => 'post',
                'posts_per_page' => 6,
                'paged' => $page,
                'post_status' => 'publish',
            ];

            $query = new WP_Query($args);
            $html = '';

            if ($query->have_posts()) {
                foreach ($query->posts as $post) {
                    $html .= view('components.blog.card', ['post' => $post])->render();
                }
            }

            return new \WP_REST_Response([
                'html' => $html,
                'max_pages' => (int) $query->max_num_pages,
                'found_posts' => (int) $query->found_posts,
            ], 200);
        } catch (\Exception $e) {
            error_log('PostApi Error: ' . $e->getMessage());
            return new \WP_REST_Response(['message' => 'Error loading posts'], 500);
        }
    }
}

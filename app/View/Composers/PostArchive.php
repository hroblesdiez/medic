<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class PostArchive extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'archive',
        'index',
        'home',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'max_pages' => $this->getMaxPages(),
            'initial_posts' => $this->getInitialPosts(),
            'apiUrl' => esc_url(rest_url('medic/v1/posts')),
            'title' => $this->title(),
        ];
    }

    /**
     * Retrieve the post title.
     */
    public function title(): string
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        return get_the_title();
    }

    /**
     * Get max pages for the posts query.
     *
     * @return int
     */
    public function getMaxPages()
    {
        global $wp_query;
        return $wp_query->max_num_pages;
    }

    /**
     * Get initial posts.
     *
     * @return array
     */
    public function getInitialPosts()
    {
        return $GLOBALS['wp_query']->posts ?? [];
    }
}

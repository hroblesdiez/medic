<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Allow SVG upload
 */
add_filter('upload_mimes', function ($mimes) {
    try {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    } catch (\Exception $e) {
        error_log('Error in filter upload_mimes: ' . $e->getMessage());
        return $mimes;
    }
});

/**
 * Inject Specialities into the primary navigation.
 */
add_filter('wp_nav_menu_objects', function ($items, $args) {
    if ($args->theme_location !== 'primary_navigation') {
        return $items;
    }

    $specialities_item_index = -1;
    foreach ($items as $index => $item) {
        // Find the "Specialities" item (by title or by CPT archive link)
        if (trim(strtolower($item->title)) === 'specialities' || $item->url === get_post_type_archive_link('speciality')) {
            $specialities_item_index = $index;
            $item->classes[] = 'menu-item-has-children';
            break;
        }
    }

    if ($specialities_item_index !== -1) {
        $parent_item = $items[$specialities_item_index];
        $parent_id = $parent_item->ID;
        $specialities = get_posts([
            'post_type' => 'speciality',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ]);

        $new_items = [];
        $has_active_child = false;
        foreach ($specialities as $speciality) {
            $is_current = (get_queried_object_id() === $speciality->ID && is_singular('speciality'));

            $new_item = new \stdClass();
            $new_item->ID = 1000000 + $speciality->ID; // High ID to avoid conflicts
            $new_item->db_id = $new_item->ID;
            $new_item->title = $speciality->post_title;
            $new_item->url = get_permalink($speciality->ID);
            $new_item->menu_item_parent = $parent_id;
            $new_item->object_id = $speciality->ID;
            $new_item->object = 'speciality';
            $new_item->type = 'post_type';
            $new_item->classes = ['menu-item', 'menu-item-type-post_type', 'menu-item-object-speciality'];
            if ($is_current) {
                $new_item->classes[] = 'current-menu-item';
                $has_active_child = true;
            }
            $new_item->target = '';
            $new_item->attr_title = '';
            $new_item->description = '';
            $new_item->xfn = '';
            $new_item->status = 'publish';

            // Fix: Add properties expected by Walker_Nav_Menu
            $new_item->current = $is_current;
            $new_item->current_item_ancestor = false;
            $new_item->current_item_parent = false;
            $new_item->filter = 'raw';

            $new_items[] = $new_item;
        }

        if ($has_active_child) {
            $parent_item->classes[] = 'current-menu-ancestor';
            $parent_item->current_item_ancestor = true;
        }

        // Insert new items after the parent item
        array_splice($items, $specialities_item_index + 1, 0, $new_items);
    }

    return $items;
}, 10, 2);

/**
 * Show all specialities on the archive page.
 */
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && $query->is_post_type_archive('speciality')) {
        $query->set('posts_per_page', -1);
    }
});

/**
 * Exclude specific pages from the Rank Math sitemap by ID
 */
add_filter('rank_math/sitemap/entry', function ($url, $type, $post) {
    $excluded_ids = [38, 66, 377];

    if ($type === 'post' && in_array($post->ID, $excluded_ids)) {
        return false;
    }
    return $url;
}, 10, 3);

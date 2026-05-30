<?php

namespace App\Services;

class SpecialitySyncService
{
  public function register(): void
  {
    add_action('save_post_speciality', [$this, 'sync'], 10, 3);
  }

  public function sync($post_id, $post, $update): void
  {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;
    if ($post->post_status !== 'publish') return;

    $slug = $post->post_name;
    if (!$slug) return;

    $taxonomy = 'speciality_type';

    $existing = get_term_by('slug', $slug, $taxonomy);

    if (!$existing) {
      wp_insert_term($post->post_title, $taxonomy, [
        'slug' => $slug,
      ]);
    } else {
      wp_update_term($existing->term_id, $taxonomy, [
        'name' => $post->post_title,
        'slug' => $slug,
      ]);
    }
  }
}

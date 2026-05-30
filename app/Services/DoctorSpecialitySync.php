<?php

namespace App\Services;

class DoctorSpecialitySync

{
  public function register(): void
  {

    add_action('save_post_doctor', function ($post_id) {

      if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
      if (wp_is_post_revision($post_id)) return;

      $speciality = get_post_meta($post_id, 'speciality', true);

      if (!$speciality) return;

      $term = get_term_by('slug', $speciality, 'speciality_type');

      if (!$term) return;

      wp_set_object_terms(
        $post_id,
        [$term->term_id],
        'speciality_type',
        false
      );
    }, 10, 1);
  }
}

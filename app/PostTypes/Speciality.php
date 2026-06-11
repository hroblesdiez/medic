<?php

namespace App\PostTypes;

class Speciality extends PostType
{
  public function name(): string
  {
    return 'speciality';
  }

  public function args(): array
  {
    return [
      'label' => 'Specialities',
      'public' => true,
      'has_archive' => true,
      'rewrite' => [
        'slug' => 'speciality',
        'with_front' => false,
      ],
      'menu_icon' => 'dashicons-heart',
      'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
      'show_in_rest' => true,
    ];
  }
}

<?php

namespace App\PostTypes;

class Doctors extends PostType
{
  public function name(): string
  {
    return 'doctors';
  }

  public function args(): array
  {
    return [
      'label' => 'Doctors',
      'public' => true,
      'has_archive' => true,
      'rewrite' => [
        'slug' => 'doctors',
        'with_front' => false,
      ],
      'menu_icon' => 'dashicons-plus',
      'supports' => ['title', 'editor', 'thumbnail'],
      'show_in_rest' => true,
      'show_ui' => true,
    ];
  }
}

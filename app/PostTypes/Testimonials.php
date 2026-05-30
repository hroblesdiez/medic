<?php

namespace App\PostTypes;

class Testimonials extends PostType
{
  public function name(): string
  {
    return 'testimonials';
  }

  public function args(): array
  {
    return [
      'label' => 'Testimonials',
      'public' => true,
      'has_archive' => false,
      'rewrite' => [
        'slug' => 'testimonials',
        'with_front' => false,
      ],
      'menu_icon' => 'dashicons-format-quote',
      'supports' => ['title', 'editor', 'thumbnail'],
      'show_in_rest' => true,
    ];
  }
}

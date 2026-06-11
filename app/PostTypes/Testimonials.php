<?php

namespace App\PostTypes;

class Testimonials extends PostType
{
  public function name(): string
  {
    return 'testimonial';
  }

  public function args(): array
  {
    return [
      'label' => 'Testimonials',
      'public' => false,
      'has_archive' => false,
      'rewrite' => [
        'slug' => 'testimonial',
        'with_front' => false,
      ],
      'menu_icon' => 'dashicons-format-quote',
      'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
      'show_in_rest' => true,
      'show_ui' => true,
    ];
  }
}

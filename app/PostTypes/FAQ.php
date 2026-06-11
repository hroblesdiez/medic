<?php

namespace App\PostTypes;

class FAQ extends PostType
{
  public function name(): string
  {
    return 'faq';
  }

  public function args(): array
  {
    return [
      'label' => 'FAQ',
      'public' => false,
      'has_archive' => false,
      'rewrite' => [
        'slug' => 'faq',
        'with_front' => false,
      ],
      'menu_icon' => 'dashicons-editor-help',
      'supports' => ['title', 'custom-fields'],
      'show_in_rest' => true,
      'show_ui' => true,
    ];
  }
}

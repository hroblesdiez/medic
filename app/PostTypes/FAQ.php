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
      'public' => true,
      'has_archive' => false,
      'rewrite' => [
        'slug' => 'faq',
        'with_front' => false,
      ],
      'menu_icon' => 'dashicons-editor-help',
      'supports' => ['title'],
      'show_in_rest' => true,
    ];
  }
}

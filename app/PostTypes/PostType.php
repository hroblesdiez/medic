<?php

namespace App\PostTypes;

abstract class PostType
{
  abstract public function name(): string;

  abstract public function args(): array;

  public function register(): void
  {
    add_action('init', function () {
      register_post_type(
        $this->name(),
        $this->args()
      );
    });
  }
}

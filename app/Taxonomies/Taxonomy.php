<?php

namespace App\Taxonomies;

abstract class Taxonomy
{
  abstract public function name(): string;

  abstract public function objectType(): array;

  abstract public function args(): array;

  public function register(): void
  {
    add_action('init', [$this, 'boot']);
  }

  public function boot(): void
  {
    register_taxonomy(
      $this->name(),
      $this->objectType(),
      $this->args()
    );
  }
}

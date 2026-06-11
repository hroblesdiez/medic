<?php

namespace App\Taxonomies;

class SpecialityType extends Taxonomy
{

  public function name(): string
  {
    return 'speciality_type';
  }

  public function objectType(): array
  {
    return ['doctors'];
  }

  public function args(): array
  {
    return [
      'label' => 'Speciality Filter',
      'public' => true,
      'hierarchical' => true,
      'show_admin_column' => true,
      'show_in_rest' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'rewrite' => [
        'slug' => 'specialities',
        'with_front' => false,
      ],
    ];
  }
}

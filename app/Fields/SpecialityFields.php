<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class SpecialityFields
{
  public function register(): void
  {
    Container::make('post_meta', __('Speciality Data'))
      ->where('post_type', '=', 'speciality')
      ->add_fields([
        Field::make('image', 'speciality_icon'),
        Field::make('text', 'speciality_name'),
        Field::make('textarea', 'speciality_description'),
      ]);
  }
}

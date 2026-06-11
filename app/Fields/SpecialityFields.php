<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class SpecialityFields
{
  public function register(): void
  {
    Container::make('post_meta', __('Speciality Information'))
      ->where('post_type', '=', 'speciality')
      ->add_fields([
        Field::make('image', 'speciality_icon', __('Icon')),
        Field::make('rich_text', 'speciality_description', __('Description')),
      ]);
  }
}

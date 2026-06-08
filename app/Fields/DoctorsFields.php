<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class DoctorsFields
{
  public function register(): void
  {
    Container::make('post_meta', __('Doctors Data'))
      ->where('post_type', '=', 'doctors')
      ->add_fields([
        Field::make('image', 'doctor_icon'),
        Field::make('text', 'doctor_name'),
        Field::make('text', 'doctor_speciality'),
        Field::make('text', 'doctor_location'),
        Field::make('text', 'doctor_price'),
        Field::make('text', 'doctor_experience'),
        Field::make('checkbox', 'exclude_from_grid', __('Exclude from grid')),
        Field::make('complex', 'doctor_availability')
  ->add_fields([
    Field::make('text', 'day'),
    Field::make('text', 'hours')
])
      ]);
  }
}

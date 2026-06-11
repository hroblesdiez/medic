<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class DoctorsFields
{
  public function register(): void
  {
    Container::make('post_meta', __('Doctor Information'))
      ->where('post_type', '=', 'doctors')
      ->add_fields([
        Field::make('text', 'doctor_location', __('Location')),
        Field::make('text', 'doctor_price', __('Price/Hourly Rate'))
          ->set_attribute('type', 'number'),
        Field::make('text', 'doctor_years_experience', __('Years of Experience'))
          ->set_attribute('type', 'number'),
        Field::make('rich_text', 'doctor_bio', __('Bio')),
        Field::make('text', 'doctor_qualifications', __('Qualifications')),
        Field::make('text', 'doctor_available_slots', __('Available Slots'))
          ->set_help_text(__('Example: 08:00 - 14:00 or 15:00 - 21:00')),
      ]);
  }
}

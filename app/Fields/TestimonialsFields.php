<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class TestimonialsFields
{
  public function register(): void
  {
    Container::make('post_meta', __('Testimonial Information'))
      ->where('post_type', '=', 'testimonial')
      ->add_fields([
        Field::make('text', 'testimonial_name', __('Patient Name')),
        Field::make('text', 'testimonial_location', __('Patient Location')),
        Field::make('rich_text', 'testimonial_text', __('Testimonial Text')),
        Field::make('text', 'testimonial_rating', __('Rating (1-5)'))
          ->set_attribute('type', 'number')
          ->set_attribute('min', 1)
          ->set_attribute('max', 5),
      ]);
  }
}

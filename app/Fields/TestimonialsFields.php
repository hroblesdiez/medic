<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class TestimonialsFields
{
  public function register(): void
  {
    Container::make('post_meta', __('Testimonial Data'))
      ->where('post_type', '=', 'testimonials')
      ->add_fields([
        Field::make('image', 'testimonial_image', __('Image')),
        Field::make('text', 'testimonial_subtitle', __('Subtitle')),
        Field::make('text', 'testimonial_title', __('Title')),
        Field::make('textarea', 'testimonial_text', __('Testimonial')),
        Field::make('text', 'testimonial_name', __('Name')),
        Field::make('text', 'testimonial_city', __('City')),
      ]);
  }
}

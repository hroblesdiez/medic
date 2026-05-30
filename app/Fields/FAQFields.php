<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class FAQFields
{
  public function register(): void
  {
    Container::make('post_meta', __('FAQ Data'))
      ->where('post_type', '=', 'faq')
      ->add_fields([
        Field::make('text', 'faq_question', __('Question')),
        Field::make('textarea', 'faq_response', __('Response')),
      ]);
  }
}

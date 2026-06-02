<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class UserFields
{
    public function register(): void
    {
        Container::make('user_meta', __('Author Settings', 'sage'))
            ->add_fields([
                Field::make('image', 'author_photo', __('Author Photo', 'sage'))
                    ->set_value_type('url'),
            ]);
    }
}

<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class OptionsPage
{
    public function register(): void
    {
        Container::make('theme_options', __('Theme options', 'sage'))
            ->add_tab('General', [
                Field::make('text', 'medic_contact_phone'),
                Field::make('image', 'medic_logo'),
                Field::make('color', 'medic_primary_color'),
            ])
            ->add_tab('Hero', [
                Field::make('image', 'medic_default_hero_image', 'Default Hero Image'),

            ]);
    }
}

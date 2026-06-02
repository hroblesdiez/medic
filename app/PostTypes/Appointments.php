<?php

namespace App\PostTypes;

class Appointments extends PostType
{
    public function name(): string
    {
        return 'appointments';
    }

    public function args(): array
    {
        return [
            'label' => 'Appointments',
            'public' => false,
            'has_archive' => false,
            'rewrite' => [
                'slug' => 'appointments',
                'with_front' => false,
            ],
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => ['title'],
            'show_in_rest' => true,
            'show_ui' => true,
        ];
    }
}

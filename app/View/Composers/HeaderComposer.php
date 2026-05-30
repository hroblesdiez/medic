<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class HeaderComposer extends Composer
{
    protected static $views = [
        'sections.header',
    ];

    public function with(): array
    {
        return [
            'logo' => $this->logo(),
            'menu' => $this->menu(),
            'cta' => $this->cta(),
        ];
    }

    protected function logo(): string
    {
        $logo_id = carbon_get_theme_option('medic_logo');

        return $logo_id
            ? wp_get_attachment_image_url($logo_id, 'full')
            : null;
    }

    protected function menu(): string
    {
        return wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'flex items-center gap-8',
            'echo' => false,
        ]);
    }

    protected function cta(): array
    {
        return [
            'text' => ['Book an appointment', 'Book'],
            'url' => '/contact',
        ];
    }
}

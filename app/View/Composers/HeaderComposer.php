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

    public function logo(): string
    {
        $logo_id = carbon_get_theme_option('medic_logo');

        if (!$logo_id) {
            return '';
        }

        return wp_get_attachment_image_url($logo_id, 'full') ?: '';
    }

    protected function menu(): string
    {
        $menu = wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'flex items-center gap-8',
            'echo' => false,
        ]);

        return is_string($menu) ? $menu : '';
    }

    protected function cta(): array
    {
        return [
            'text' => ['Book an appointment', 'Book'],
            'url' => home_url('/doctors'),
        ];
    }
}

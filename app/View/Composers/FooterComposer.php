<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FooterComposer extends Composer
{
  protected static $views = [
    'sections.footer',
  ];

  public function with(): array
  {
    return [
      'companyMenu' => $this->menu('footer_company'),
      'utilitiesMenu' => $this->menu('footer_utilities'),
      'specialitiesMenu' => $this->menu('footer_specialities'),
      'treatmentsMenu' => $this->menu('footer_treatments'),
    ];
  }

  protected function menu(string $location): string
  {
    $filter = function ($items) use ($location) {
      foreach ($items as $item) {
        if ($location === 'footer_specialities') {
          $slug = sanitize_title($item->title);
          $item->url = home_url("/speciality/{$slug}/");
        } elseif ($item->title === 'Contact') {
          $item->url = home_url('/contact/');
        } else {
          $item->url = home_url('/');
        }
      }
      return $items;
    };

    add_filter('wp_nav_menu_objects', $filter);

    $html = wp_nav_menu([
      'theme_location' => $location,
      'echo' => false,
      'container' => false,
      'menu_class' => 'space-y-2 text-sm text-gray-600',
    ]);

    remove_filter('wp_nav_menu_objects', $filter);

    return $html;
  }
}

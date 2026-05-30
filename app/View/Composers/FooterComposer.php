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
    return wp_nav_menu([
      'theme_location' => $location,
      'echo' => false,
      'container' => false,
      'menu_class' => 'space-y-2 text-sm text-gray-600',
    ]);
  }
}

<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class HeroComposer extends Composer
{
  protected static $views = [
    '*',
  ];

  public function defaultHeroImage()
  {
    $image_id = carbon_get_theme_option('medic_default_hero_image');

    return $image_id
      ? wp_get_attachment_image_url($image_id, 'full')
      : null;
  }
}

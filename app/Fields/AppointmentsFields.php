<?php

namespace App\Fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class AppointmentsFields
{
  public function register(): void
  {
    Container::make('post_meta', __('Appointments Data'))
      ->where('post_type', '=', 'appointments')
      ->add_fields([

        Field::make('select', 'doctor_id')
          ->set_options(function () {
            $doctors = get_posts([
              'post_type' => 'doctors',
              'numberposts' => -1,
            ]);

            $options = [];

            foreach ($doctors as $doctor) {
              $options[$doctor->ID] = $doctor->post_title;
            }

            return $options;
          }),

        Field::make('text', 'date'),

        Field::make('text', 'time')
          ->set_attribute('placeholder', '09:30'),

        Field::make('text', 'name'),


        Field::make('text', 'email')
          ->set_attribute('type', 'email'),

        Field::make('select', 'status')
          ->set_options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            'no_show' => 'No Show',
          ])
          ->set_default_value('pending'),

      ]);
  }
}

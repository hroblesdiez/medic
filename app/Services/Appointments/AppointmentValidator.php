<?php

namespace App\Services\Appointments;

use WP_Query;

class AppointmentValidator
{
  public function slotIsAvailable(int $doctorId, string $date, string $time): bool
  {
    $query = new WP_Query([
      'post_type' => 'appointments',
      'post_status' => 'publish',
      'meta_query' => [
        'relation' => 'AND',
        [
          'key' => 'doctor_id',
          'value' => $doctorId,
        ],
        [
          'key' => 'date',
          'value' => $date,
        ],
        [
          'key' => 'time',
          'value' => $time,
        ],
        [
          'key' => 'status',
          'value' => ['cancelled'],
          'compare' => 'NOT IN'
        ]
      ]
    ]);

    return $query->found_posts === 0;
  }
}

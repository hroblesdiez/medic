<?php

namespace App\Services\Appointments;

class AppointmentRepository
{
  public function create(array $data): int
  {
    return wp_insert_post([
      'post_type' => 'appointments',
      'post_status' => 'publish',
      'post_title' => sprintf(
        'Appointment - %d - %s %s',
        $data['doctor_id'],
        $data['date'],
        $data['time']
      ),
    ]);
  }

  public function saveMeta(int $id, array $data): void
  {
    foreach ($data as $key => $value) {
      update_post_meta($id, '_' . $key, $value);
    }
  }
}

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

  public function find(int $id): ?object
  {
    $post = get_post($id);
    if (!$post || $post->post_type !== 'appointments') {
      return null;
    }

    return (object) [
      'id'     => $id,
      'doctor' => get_the_title(get_post_meta($id, '_doctor_id', true)),
      'date'   => get_post_meta($id, '_date', true),
      'time'   => get_post_meta($id, '_time', true),
      'name'   => get_post_meta($id, '_name', true),
    ];
  }
}

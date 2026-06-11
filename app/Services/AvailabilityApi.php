<?php

namespace App\Services;

use WP_REST_Request;
use WP_REST_Response;

class AvailabilityApi
{
  public function register(): void
  {
    add_action('rest_api_init', [$this, 'registerRoutes']);
  }

  public function registerRoutes(): void
  {
    register_rest_route('medic/v1', '/availability', [
      'methods' => 'GET',
      'callback' => [$this, 'getAvailability'],
      'permission_callback' => function () {
        return true;
      },
    ]);
  }

  /**
   * Generate slots from a range type "08:00 to 12:00"
   */
  private function generateSlotsFromRange(string $range, int $interval = 30): array
  {
    if (!preg_match('/(\d{1,2}:\d{2})\s*(?:a|-)\s*(\d{1,2}:\d{2})/i', $range, $matches)) {
      return [];
    }

    $start = strtotime($matches[1]);
    $end = strtotime($matches[2]);

    if (!$start || !$end || $start >= $end) {
      return [];
    }

    $slots = [];

    while ($start < $end) {
      $slots[] = date('H:i', $start);
      $start += $interval * 60;
    }

    return $slots;
  }

  /**
   * Transform availability Carbon Field in slots
   */
  private function generateSlotsFromAvailability($availability, int $interval = 30): array
  {
    $slots = [];

    if (!is_array($availability)) {
      return [];
    }

    foreach ($availability as $item) {

      if (empty($item['hours'])) {
        continue;
      }

      $range = trim($item['hours']);
      $range = preg_replace('/\s+/u', ' ', $range);

      $slots = array_merge(
        $slots,
        $this->generateSlotsFromRange($range, $interval)
      );
    }

    return array_values(array_unique($slots));
  }

  /**
   * Get slots already booked
   * CPT: appointments
   */
  private function getBookedSlots(int $doctorId, ?string $date = null): array
  {
    $args = [
      'post_type' => 'appointments',
      'post_status' => ['publish', 'pending', 'confirmed'],
      'posts_per_page' => -1,
      'meta_query' => [
        [
          'key' => '_doctor_id',
          'value' => $doctorId,
          'compare' => '='
        ]
      ]
    ];

    if ($date) {
      $args['meta_query'][] = [
        'key' => '_date',
        'value' => $date,
        'compare' => '='
      ];
    }

    $query = new \WP_Query($args);

    $booked = [];

    if ($query->have_posts()) {
      foreach ($query->posts as $post) {
        $time = get_post_meta($post->ID, '_time', true);
        if ($time) {
          $booked[] = $time;
        }
      }
    }

    return array_values(array_unique($booked));
  }

  /**
   * Main API
   */
  public function getAvailability(WP_REST_Request $request): WP_REST_Response
  {
    try {

      $doctorId = (int) $request->get_param('doctor');
      $date = $request->get_param('date');

      if (!$doctorId) {
        return new WP_REST_Response([
          'message' => 'Doctor ID is required',
        ], 400);
      }

      $doctor = get_post($doctorId);

      if (!$doctor || $doctor->post_type !== 'doctors') {
        return new WP_REST_Response([
          'message' => 'Doctor not found',
        ], 404);
      }

      /**
       * Carbon Field availability
       */

      $availability = [];
      $day   = get_post_meta($doctorId, '_doctor_availability|day|0|0|value', true);
      $hours = get_post_meta($doctorId, '_doctor_availability|hours|0|0|value', true);

      if ($hours) {
        $availability[] = [
          'day'   => $day,
          'hours' => $hours,
        ];
      }
      if (empty($availability)) {
        return new WP_REST_Response([
          'doctor_id' => $doctorId,
          'slots' => [],
        ], 200);
      }

      /**
       * Generate base slots
       */
      $slots = $this->generateSlotsFromAvailability($availability, 30);

      /**
       *  block slots already booked
       */
      $bookedSlots = $this->getBookedSlots($doctorId, $date);

      if (!empty($bookedSlots)) {
        $slots = array_values(array_diff($slots, $bookedSlots));
      }

      return new WP_REST_Response([
        'doctor_id' => $doctorId,
        'date' => $date,
        'slots' => $slots,
        'booked' => $bookedSlots,
      ], 200);
    } catch (\Throwable $e) {

      return new WP_REST_Response([
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
      ], 500);
    }
  }
}

<?php

namespace App\Api;

use WP_REST_Request;
use WP_REST_Response;
use App\Services\Appointments\AppointmentService;
use App\Services\Appointments\AppointmentRepository;

class AppointmentsApi
{
  private AppointmentService $service;

  public function __construct()
  {
    $this->service = new AppointmentService(
      new AppointmentRepository()
    );
  }

  public function register(): void
  {
    add_action('rest_api_init', [$this, 'routes']);
  }

  public function routes(): void
  {
    register_rest_route('medic/v1', '/appointments', [
      'methods' => 'POST',
      'callback' => [$this, 'store'],
      'permission_callback' => '__return_true',
    ]);
  }

  public function store(WP_REST_Request $request): WP_REST_Response
  {
    error_log('STORE EXECUTED');
    try {

      $id = $this->service->create([
        'doctor_id' => (int) $request->get_param('doctor_id'),
        'date'      => $request->get_param('date'),
        'time'      => $request->get_param('time'),
        'email'     => $request->get_param('email'),
        'name'      => $request->get_param('name'),
      ]);

      return new WP_REST_Response([
        'message' => 'Appointment created',
        'id' => $id
      ], 201);
    } catch (\Throwable $e) {

      return new WP_REST_Response([
        'message' => $e->getMessage()
      ], 400);
    }
  }
}

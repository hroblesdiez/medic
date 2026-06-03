<?php

namespace App\Services\Appointments;

class AppointmentFormListener
{
  public function register(): void
  {
    add_action('fluentform_submission_inserted', [$this, 'handle'], 10, 3);
    add_filter('fluentform/submission_confirmation', [$this, 'appendAppointmentData'], 10, 3);
  }

  public function handle($entryId, $formData, $form): void
  {
    if ((int) $form->id !== 3) {
      return;
    }

    $service = new AppointmentService(new AppointmentRepository());

    $postId = $service->create([
      'doctor_id' => (int) ($formData['doctor_id'] ?? 0),
      'date'      => $formData['datetime'] ?? '',
      'time'      => $formData['slot_time'] ?? '',
      'email'     => $formData['email'] ?? '',
      'name'      => trim(
        ($formData['names']['first_name'] ?? '') .
          ' ' .
          ($formData['names']['last_name'] ?? '')
      ),
    ]);

    $repository  = new AppointmentRepository();
    $appointment = $repository->find($postId);

    if ($appointment) {
      set_transient('appointment_summary_form_3', [
        'doctor' => $appointment->doctor,
        'date'   => $appointment->date,
        'time'   => $appointment->time,
        'name'   => $appointment->name,
      ], 30);
    }
  }

  public function appendAppointmentData($response, $form, $settings): mixed
  {
    if ((int) $form->id !== 3) {
      return $response;
    }

    $summary = get_transient('appointment_summary_form_3');

    if (!$summary) {
      return $response;
    }

    delete_transient('appointment_summary_form_3');

    $response['appointment_summary'] = $summary;

    return $response;
  }
}

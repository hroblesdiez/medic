<?php

namespace App\Services\Appointments;

class AppointmentFormListener
{
  public function register(): void
  {
    add_action('fluentform_submission_inserted', [$this, 'handle'], 10, 3);
    add_filter('fluentform/submission_confirmation', [$this, 'appendAppointmentData'], 10, 3);
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

  public function handle($entryId, $formData, $form): void
  {
    if ((int) $form->id !== 3) {
      return;
    }

    $rawDatetime = trim($formData['date'] ?? '');

    if ($rawDatetime && !$this->isDatetimeInFuture($rawDatetime)) {
      if (function_exists('wpFluent')) {
        wpFluent()->table('fluentform_submissions')->where('id', $entryId)->delete();
      }
      error_log('Medic: rejected past appointment submission for entry ' . $entryId);
      return;
    }

    $repository = new AppointmentRepository();
    $service    = new AppointmentService($repository);

    try {
      $postId = $service->create([
        'doctor_id' => (int) ($formData['doctor_id'] ?? 0),
        'date'      => $formData['date'] ?? '',
        'time'      => $formData['time'] ?? '',
        'email'     => $formData['email'] ?? '',
        'name'      => trim(
          ($formData['names']['first_name'] ?? '') .
            ' ' .
            ($formData['names']['last_name'] ?? '')
        ),
      ]);
    } catch (\RuntimeException $e) {
      error_log('Medic: slot not available for entry ' . $entryId . ' - ' . $e->getMessage());
      return;
    }

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

  private function isDatetimeInFuture(string $raw): bool
  {
    $dt = \DateTime::createFromFormat('d/m/Y H:i', $raw);

    if ($dt === false) {
      $dt = \DateTime::createFromFormat('d/m/Y', $raw);

      if ($dt === false) {
        return true;
      }

      $dt->setTime(23, 59, 59);
    }

    return $dt > new \DateTime();
  }
}

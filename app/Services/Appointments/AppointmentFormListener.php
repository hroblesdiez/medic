<?php

namespace App\Services\Appointments;

class AppointmentFormListener
{
  public function register(): void
  {
    add_action(
      'fluentform_submission_inserted',
      [$this, 'handle'],
      10,
      3
    );
    add_filter('fluentform/submission_confirmation', [$this, 'appendAppointmentData'], 10, 3);
  }

  public function appendAppointmentData($response, $form, $entry)
  {
    if ((int) $form->id !== 3) return $response;

    try {
      $entryId = is_array($entry) ? ($entry['id'] ?? null) : ($entry->id ?? null);

      if (!$entryId) return $response;

      $repository  = new AppointmentRepository();
      $appointment = $repository->find((int) $entryId);

      if ($appointment) {
        $response['appointment_summary'] = [
          'doctor' => $appointment->doctor,
          'date'   => $appointment->date,
          'time'   => $appointment->time,
          'name'   => $appointment->name,
        ];
      } else {
        error_log('Medic Debug: appointment not found for entry ' . $entryId);
      }
    } catch (\Throwable $e) {
      error_log('Medic Error (Summary): ' . $e->getMessage());
    }

    return $response;
  }

  public function handle($entryId, $formData, $form): void
  {
    if ((int) $form->id !== 3) {
      return;
    }

    // Guard: reject submissions with a datetime in the past.
    // FluentForms stores the date as d/m/Y H:i when time is enabled.
    $rawDatetime = trim($formData['datetime'] ?? '');

    if ($rawDatetime && !$this->isDatetimeInFuture($rawDatetime)) {
      // Remove the entry FluentForms already inserted so no stale data remains.
      if (function_exists('wpFluent')) {
        wpFluent()->table('fluentform_submissions')->where('id', $entryId)->delete();
      }

      error_log('Medic: rejected past appointment submission for entry ' . $entryId);
      return;
    }

    $service = new AppointmentService(
      new AppointmentRepository()
    );

    $service->create([
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
  }

  /**
   * Returns true when the given datetime string is strictly in the future.
   * Accepts d/m/Y H:i (FluentForms default with time enabled).
   * Falls back gracefully — if the string cannot be parsed we allow the
   * submission through so a format mismatch does not silently swallow data.
   */
  private function isDatetimeInFuture(string $raw): bool
  {
    $dt = \DateTime::createFromFormat('d/m/Y H:i', $raw);

    if ($dt === false) {
      // Try date-only fallback in case time is missing
      $dt = \DateTime::createFromFormat('d/m/Y', $raw);

      if ($dt === false) {
        return true;
      }

      // Date only: any time today is allowed, only strictly past dates are blocked
      $dt->setTime(23, 59, 59);
    }

    return $dt > new \DateTime();
  }
}

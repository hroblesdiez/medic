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
  }

  public function handle($entryId, $formData, $form): void
  {

    if ((int) $form->id !== 3) {
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
}

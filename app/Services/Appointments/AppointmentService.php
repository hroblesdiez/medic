<?php

namespace App\Services\Appointments;

class AppointmentService
{
  public function __construct(
    private AppointmentRepository $repository,
    private AppointmentValidator $validator = new AppointmentValidator()
  ) {}

  public function create(array $data): int
  {
    if (!$this->validator->slotIsAvailable($data['doctor_id'], $data['date'], $data['time'])) {
      throw new \RuntimeException('This slot is no longer available. Please choose another time.');
    }

    $id = $this->repository->create($data);

    $this->repository->saveMeta($id, [
      'doctor_id' => $data['doctor_id'],
      'date'      => $data['date'],
      'time'      => $data['time'],
      'email'     => $data['email'],
      'name'      => $data['name'],
    ]);

    return $id;
  }
}

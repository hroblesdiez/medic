<?php

namespace App\Services\Appointments;

class AppointmentService
{
  public function __construct(
    private AppointmentRepository $repository
  ) {}

  public function create(array $data): int
  {
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

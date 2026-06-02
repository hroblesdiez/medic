<?php

namespace App\Services\Appointments;

class AppointmentSlotLock
{
  public function lock(int $doctorId, string $date, string $time): string
  {
    return md5($doctorId . $date . $time);
  }
}

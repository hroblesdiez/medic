<?php

namespace App\Services\Appointments;

class AppointmentStatus
{
  const PENDING   = 'pending';
  const CONFIRMED = 'confirmed';
  const CANCELLED = 'cancelled';
  const COMPLETED = 'completed';
  const NO_SHOW   = 'no_show';

  public static function all(): array
  {
    return [
      self::PENDING,
      self::CONFIRMED,
      self::CANCELLED,
      self::COMPLETED,
      self::NO_SHOW,
    ];
  }
}

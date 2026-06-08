<?php

namespace App\View\Composers;

use App\Services\Doctors\DoctorService;
use Roots\Acorn\View\Composer;

class DoctorSingle extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single-doctors',
    ];

    /**
     * @var DoctorService
     */
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'doctor' => $this->doctorService->getDoctorData(get_the_ID()),
        ];
    }
}

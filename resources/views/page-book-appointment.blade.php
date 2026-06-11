@extends('layouts.app')

@section('content')

@php
$doctor_id = request()->get('doctor');
$doctor = $doctor_id ? get_post($doctor_id) : null;
@endphp

<section class="booking-section">

  <div class="container">

    <div class="booking-wrapper" x-data="appointmentForm()">

      {{-- Page Title (Ocultar al confirmar) --}}
      <h1 x-show="!submitted" class="mb-8">
        Book Appointment
      </h1>

      <div class="booking-card">

        {{-- FORMULARIO Y DATOS DEL DOCTOR (Se ocultan al confirmar) --}}
        <div x-show="!submitted" x-collapse>
          @if($doctor)
          <div class="doctor-info-card">
            <p class="doctor-info-label">Appointment Request</p>
            <h2 class="doctor-info-name">
              {{ $doctor->post_title }}
            </h2>
            <p class="doctor-info-sub">
              Please complete the form below to request your appointment.
            </p>
          </div>
          @else
          <div class="alert-no-doctor">
            <p class="alert-no-doctor-text">
              No doctor selected. Please go back and choose a doctor.
            </p>
          </div>
          @endif

          <div id="booking-form">
            {!! do_shortcode('[fluentform id="3"]') !!}
          </div>
        </div>

        {{-- TARJETA DE ÉXITO (Solo aparece al confirmar) --}}
        <template x-if="submitted">
          <div
            x-show="submitted"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="success-container">
            <div class="success-icon-wrapper">
              <svg class="success-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>

            <div class="success-header">
              <h2 class="success-title">Appointment Confirmed</h2>
              <p class="success-message">
                Thank you <span class="font-semibold text-text-primary" x-text="summary.name"></span>. Your request has been received.
              </p>
            </div>

            <div class="success-summary">
              <div class="summary-item">
                <span class="summary-label">Doctor</span>
                <span class="summary-value" x-text="summary.doctor"></span>
              </div>
              <div class="summary-item">
                <span class="summary-label">Date</span>
                <span class="summary-value" x-text="summary.date"></span>
              </div>
              <div class="summary-item">
                <span class="summary-label">Time</span>
                <span class="summary-value" x-text="summary.time"></span>
              </div>
            </div>

            <div class="booking-actions">
              <button
                @click="window.location.reload()"
                class="btn-booking">
                Book Another Appointment
              </button>
            </div>
          </div>
        </template>

        {{-- Hidden doctor id for JS --}}
        @if($doctor)
        <input type="hidden" id="doctor_id_value" value="{{ $doctor->ID }}">
        @endif

      </div>
    </div>
  </div>
</section>

@endsection
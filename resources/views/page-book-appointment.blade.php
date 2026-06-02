@extends('layouts.app')

@section('content')

@php
$doctor_id = request()->get('doctor');
$doctor = $doctor_id ? get_post($doctor_id) : null;
@endphp

<section class="py-16 bg-[var(--color-surface-soft)] min-h-screen">
  <div class="container">

    <div class="max-w-3xl mx-auto" x-data="appointmentForm()"
      x-init="init()">

      {{-- Page Title --}}
      <h1 class="text-4xl font-bold mb-8 text-[var(--color-text-primary)]">
        Book Appointment
      </h1>

      <div class="bg-white rounded-3xl shadow-lg p-8">

        {{-- Doctor Info --}}
        @if($doctor)

        <div class="mb-8 rounded-xl bg-[var(--color-primary-soft)] p-6 border border-[var(--color-border-light)]">

          <p class="text-sm text-[var(--color-text-secondary)]">
            Appointment Request
          </p>

          <h2 class="mt-2 text-xl font-bold text-[var(--color-text-primary)]">
            {{ $doctor->post_title }}
          </h2>

          <p class="text-xs text-[var(--color-text-muted)] mt-1">
            Please complete the form below to request your appointment.
          </p>

        </div>

        @else

        <div class="mb-8 rounded-xl bg-yellow-50 p-6 border border-yellow-200">
          <p class="text-sm text-yellow-700 font-medium">
            No doctor selected. Please go back and choose a doctor.
          </p>
        </div>

        @endif

        {{-- Fluent Form --}}
        <div id="booking-form">
          {!! do_shortcode('[fluentform id="3"]') !!}
        </div>

        {{-- Hidden doctor id for JS --}}
        @if($doctor)
        <input
          type="hidden"
          id="doctor_id_value"
          value="{{ $doctor->ID }}">
        @endif

      </div>

    </div>

  </div>
</section>

@endsection
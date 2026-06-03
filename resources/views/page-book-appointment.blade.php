@extends('layouts.app')

@section('content')

@php
$doctor_id = request()->get('doctor');
$doctor = $doctor_id ? get_post($doctor_id) : null;
@endphp

<section class="py-16 bg-[var(--color-surface-soft)] min-h-screen">
  <div class="container">

    <div class="max-w-3xl mx-auto" x-data="appointmentForm()">

      {{-- Page Title (Ocultar al confirmar) --}}
      <h1 x-show="!submitted" class="text-4xl font-bold mb-8 text-[var(--color-text-primary)]">
        Book Appointment
      </h1>

      <div class="bg-white rounded-3xl shadow-lg p-8">

        {{-- FORMULARIO Y DATOS DEL DOCTOR (Se ocultan al confirmar) --}}
        <div x-show="!submitted" x-collapse>
          @if($doctor)
          <div class="mb-8 rounded-xl bg-[var(--color-primary-soft)] p-6 border border-[var(--color-border-light)]">
            <p class="text-sm text-[var(--color-text-secondary)]">Appointment Request</p>
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
            class="py-4">
            <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-6 mx-auto">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>

            <div class="text-center mb-10">
              <h2 class="text-3xl font-bold tracking-tight text-gray-900">Appointment Confirmed</h2>
              <p class="mt-3 text-lg text-gray-600">
                Thank you <span class="font-semibold text-gray-900" x-text="summary.name"></span>. Your request has been received.
              </p>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 space-y-4 border border-gray-100">
              <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                <span class="text-sm text-gray-500 uppercase font-bold tracking-wider">Doctor</span>
                <span class="text-base font-semibold text-gray-900" x-text="summary.doctor"></span>
              </div>
              <div class="flex justify-between items-center py-2 border-b border-gray-200/50">
                <span class="text-sm text-gray-500 uppercase font-bold tracking-wider">Date</span>
                <span class="text-base font-semibold text-gray-900" x-text="summary.date"></span>
              </div>
              <div class="flex justify-between items-center py-2">
                <span class="text-sm text-gray-500 uppercase font-bold tracking-wider">Time</span>
                <span class="text-base font-semibold text-gray-900" x-text="summary.time"></span>
              </div>
            </div>

            <div class="mt-10">
              <button
                @click="window.location.reload()"
                class="w-full py-4 px-6 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition-all cursor-pointer shadow-lg shadow-gray-200">
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
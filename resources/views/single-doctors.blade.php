@extends('layouts.app')

@section('content')
  @if ($doctor)
    <article class="doctor-single">
      <div class="container mx-auto px-4">
        {{-- Hero Section --}}
        <header class="doctor-hero">
          <div class="doctor-hero-image">
            <img src="{{ $doctor['image'] }}" alt="{{ $doctor['name'] }}">
          </div>
          <div class="doctor-hero-content">
            <span class="doctor-specialty-badge">{{ $doctor['speciality'] }}</span>
            <h1 class="doctor-name">{{ $doctor['name'] }}</h1>
            
            <div class="doctor-meta">
              <div class="doctor-meta-item">
                <svg class="doctor-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>{{ $doctor['location'] }}</span>
              </div>
              <div class="doctor-meta-item">
                <svg class="doctor-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>{{ $doctor['experience'] }}</span>
              </div>
              <div class="doctor-meta-item">
                <svg class="doctor-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ $doctor['price'] }}</span>
              </div>
            </div>
          </div>
        </header>

        <div class="doctor-content-grid">
          {{-- Main Content --}}
          <div class="doctor-main-content">
            <section>
              <h2 class="doctor-section-title">Biography</h2>
              <div class="doctor-bio">
                {!! $doctor['bio'] !!}
              </div>
            </section>

            @if (!empty($doctor['specialities']))
              <section>
                <h2 class="doctor-section-title">Specialities</h2>
                <div class="doctor-specialities-list">
                  @foreach ($doctor['specialities'] as $speciality)
                    <span class="doctor-speciality-tag">{{ $speciality }}</span>
                  @endforeach
                </div>
              </section>
            @endif
          </div>

          {{-- Sidebar with Appointment --}}
          <aside class="doctor-sidebar">
            <div class="doctor-cta-card" 
                 x-data="doctorAppointment({{ $doctor['id'] }}, '{{ $doctor['name'] }}')"
                 data-doctor-id="{{ $doctor['id'] }}">
              
              <div x-show="!submitted">
                <h3 class="doctor-cta-title">Book an Appointment</h3>
                <p class="doctor-cta-text">Select a date and time to meet with {{ $doctor['name'] }}.</p>
                
                <div class="doctor-appointment-form">
                  @include('forms.appointment-mini')
                </div>
              </div>

              {{-- Success Message / Summary (Misma arquitectura que page-book-appointment) --}}
              <template x-if="submitted">
                <div
                  x-show="submitted"
                  x-transition:enter="transition ease-out duration-500"
                  x-transition:enter-start="opacity-0 translate-y-4"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  class="success-container">
                  <div class="success-icon-wrapper !bg-white">
                    <svg class="success-icon !text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </div>

                  <div class="success-header">
                    <h2 class="success-title !text-white !text-2xl">Confirmed</h2>
                    <p class="success-message !text-blue-100 !text-sm">
                      Thank you <span class="font-semibold text-white" x-text="summary.name"></span>. Your request has been received.
                    </p>
                  </div>

                  <div class="success-summary !bg-white/10 !border-white/20">
                    <div class="summary-item !border-white/10">
                      <span class="summary-label !text-blue-200">Doctor</span>
                      <span class="summary-value !text-white" x-text="summary.doctor"></span>
                    </div>
                    <div class="summary-item !border-white/10">
                      <span class="summary-label !text-blue-200">Date</span>
                      <span class="summary-value !text-white" x-text="summary.date"></span>
                    </div>
                    <div class="summary-item !border-white/10">
                      <span class="summary-label !text-blue-200">Time</span>
                      <span class="summary-value !text-white" x-text="summary.time"></span>
                    </div>
                  </div>

                  <div class="booking-actions">
                    <button
                      @click="window.location.reload()"
                      class="w-full py-4 px-8 bg-white text-blue-600 rounded-xl font-bold hover:bg-blue-50 transition-all shadow-lg cursor-pointer">
                      Book Another
                    </button>
                  </div>
                </div>
              </template>

              {{-- Error Message --}}
              <div x-show="error" x-cloak class="mt-4 p-4 bg-red-500 rounded-lg text-white text-sm">
                <p>Something went wrong. Please check your connection and try again.</p>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </article>
  @endif
@endsection

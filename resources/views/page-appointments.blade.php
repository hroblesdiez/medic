@extends('layouts.app')

@section('content')

<div class="appointments-page">
  <div class="content-container">

    <header class="appointments-header">
      <h1 class="appointments-title">
        Book an <span>Appointment</span>
      </h1>
      <p class="appointments-description">
        Consult with our top specialists who contribute to our health blog. Choose your preferred expert and check their availability.
      </p>
    </header>

    <div class="grid-4-cols items-stretch">
      @foreach($specialists as $specialist)
      @include('partials.specialist-card', ['specialist' => $specialist])
      @endforeach
    </div>

    @if(empty($specialists))
    <div class="appointments-empty">
      <p class="appointments-empty-text">No specialists found at the moment.</p>
    </div>
    @endif

    <div class="appointments-cta">
      <div class="appointments-cta-container">
        <div class="appointments-cta-content">
          <h2 class="appointments-cta-title">Can't find what you're looking for?</h2>
          <p class="appointments-cta-text">
            Browse our full directory of qualified doctors across all specialities.
          </p>
        </div>
        <a href="{{ home_url('/doctors') }}" class="appointments-cta-button">
          View All Doctors
        </a>
      </div>

      {{-- Decorative circles --}}
      <div class="appointments-cta-circle appointments-cta-circle--top"></div>
      <div class="appointments-cta-circle appointments-cta-circle--bottom"></div>
    </div>

  </div>
</div>
@endsection
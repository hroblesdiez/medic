@extends('layouts.app')

@section('content')
{{-- Speciality Introduction Section --}}
<article @php(post_class('speciality-intro section-container pt-4! lg:pt-8!'))>
  <div class="content-container">
    <div class="speciality-intro__grid">
      {{-- Left column: Content --}}
      <div class="speciality-intro__content">
        <header>
          <h1 class="speciality-intro__title">{{ get_the_title() }}</h1>
        </header>

        <div class="speciality-intro__text prose max-w-none">
          @php(the_content())
        </div>
      </div>

      {{-- Right column: Featured Image --}}
      <div class="speciality-intro__image-wrapper">
        @if(has_post_thumbnail())
        {!! wp_get_attachment_image(get_post_thumbnail_id(), 'large', false, [
        'class' => 'speciality-intro__image',
        'loading' => 'eager'
        ]) !!}
        @else
        <div class="speciality-intro__placeholder">
          <svg class="w-24 h-24 text-[var(--color-primary-soft)]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
        </div>
        @endif
      </div>
    </div>
  </div>
</article>

{{-- Top Doctors Section --}}
@if($top_doctors)
<section class="top-doctors section-container bg-[var(--color-surface-soft)]">
  <div class="content-container">
    <header class="section-header mb-12">
      <h2 class="section-title">Most Experienced {{ get_the_title() }} Specialists</h2>
    </header>

    <div class="doctors-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      @foreach($top_doctors as $doctor)
      @include('partials.doctor-card', ['doctor' => $doctor])
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- CTA Section --}}
<section class="cta-section section-container">
  <div class="content-container">
    <div class="cta-banner">
      <div class="cta-banner__container">
        <div class="text-center lg:text-left">
          <h2 class="cta-banner__title">Need help choosing the right specialist?</h2>
          <p class="cta-banner__description">
            Browse our complete directory of verified medical professionals and book an appointment online.
          </p>
          <div class="flex justify-center lg:justify-start">
            <a href="/doctors/" class="btn btn-secondary hover:bg-primary-dark! btn-lg">
              Book an Appointment
            </a>
          </div>
        </div>
        {{-- Decorative element if needed, otherwise matches banner style --}}
      </div>
    </div>
  </div>
</section>
@endsection
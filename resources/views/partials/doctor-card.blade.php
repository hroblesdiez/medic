@php
/**
* @var WP_Post $doctor
*/

$location = carbon_get_post_meta($doctor->ID, 'doctor_location');
$price = carbon_get_post_meta($doctor->ID, 'doctor_price');
$experience = carbon_get_post_meta($doctor->ID, 'doctor_experience');

$custom_image_id = carbon_get_post_meta($doctor->ID, 'doctor_icon');
$thumbnail = $custom_image_id
? wp_get_attachment_image_url($custom_image_id, 'large')
: get_the_post_thumbnail_url($doctor->ID, 'large');

$specialities = get_the_terms($doctor->ID, 'speciality_type');

// SAFE URL PARAMS
$doctor_name = rawurlencode($doctor->post_title);
$booking_url = home_url("/book-appointment?doctor={$doctor->ID}");
@endphp

<article class="doctor-card group">

  {{-- Image --}}
  <div class="doctor-card__image-container">
    @if($thumbnail)
    <img src="{{ $thumbnail }}" alt="{{ esc_attr($doctor->post_title) }}" class="doctor-card__image">
    @else
    <div class="w-full h-full flex items-center justify-center bg-primary-soft">
      <svg class="w-16 h-16 text-primary-light" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
    </div>
    @endif

    @if($price)
    <div class="doctor-card__price">
      {{ $price }} PLN<span class="text-white/60 font-medium ml-1">/visit</span>
    </div>
    @endif
  </div>

  {{-- Content --}}
  <div class="doctor-card__content">

    <div class="flex items-center justify-between gap-4">
      <div class="flex flex-wrap gap-2">
        @if($specialities && !is_wp_error($specialities))
        @foreach(array_slice($specialities, 0, 1) as $speciality)
        <span class="doctor-card__badge">
          {{ $speciality->name }}
        </span>
        @endforeach
        @endif
      </div>
    </div>

    <div class="mt-4">

      {{-- TITLE (ONLY detail navigation) --}}
      <h3 class="doctor-card__title">
        <a href="{{ get_permalink($doctor->ID) }}" class="hover:underline">
          {{ $doctor->post_title }}
        </a>
      </h3>

      <div class="flex flex-col gap-2 mt-3 mb-4">

        @if($location)
        <div class="doctor-card__info">
          <svg class="doctor-card__icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          </svg>
          {{ $location }}
        </div>
        @endif

        @if($experience)
        <div class="doctor-card__info">
          <svg class="doctor-card__icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span>{{ $experience }} {{ $experience == 1 ? 'year' : 'years' }} exp.</span>
        </div>
        @endif

      </div>
    </div>

    {{-- CTA BUTTON --}}
    <div class="mt-auto">

      <a
        href="{{ $booking_url }}"
        class="doctor-card__button"
        @click.stop
        rel="noopener noreferrer">
        Book Appointment
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
            d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
      </a>

    </div>

  </div>
</article>
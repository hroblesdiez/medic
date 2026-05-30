@php
/**
* @var WP_Post $doctor
*/

// Carbnon fields
$location = carbon_get_post_meta($doctor->ID, 'doctor_location');
$price = carbon_get_post_meta($doctor->ID, 'doctor_price');
$experience = carbon_get_post_meta($doctor->ID, 'doctor_experience');

// Image
$custom_image_id = carbon_get_post_meta($doctor->ID, 'doctor_icon');
$thumbnail = $custom_image_id
? wp_get_attachment_image_url($custom_image_id, 'large')
: get_the_post_thumbnail_url($doctor->ID, 'large');

// Taxonomies (Specialities)
$specialities = get_the_terms($doctor->ID, 'speciality_type');

@endphp

<article class="bg-white rounded-[var(--radius-xl)] shadow-[var(--shadow-card)] border border-[var(--color-border-light)] overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">

  {{-- Image container --}}
  <div class="relative h-64 bg-[var(--color-surface-muted)] overflow-hidden shrink-0">
    @if($thumbnail)
    <img src="{{ $thumbnail }}" alt="{{ $doctor->post_title }}" class="w-full h-full object-cover object-top group-hover:scale-110 transition-transform duration-700 ease-out">
    @else
    <div class="w-full h-full flex items-center justify-center bg-[var(--color-primary-soft)]">
      <svg class="w-16 h-16 text-[var(--color-primary-light)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
    </div>
    @endif

    {{-- Price --}}
    @if($price)
    <div class="absolute bottom-4 left-4 bg-accent-orange text-white! px-3.5 py-1.5 rounded-lg text-sm font-bold shadow-lg">
      {{ $price }} PLN<span class="text-white/60 font-medium ml-1">/visit</span>
    </div>
    @endif
  </div>

  {{-- Card content --}}
  <div class="p-6 lg:p-7 flex flex-col grow">

    <div class="flex items-center justify-between gap-4 mb-4">
      <div class="flex flex-wrap gap-2">
        @if($specialities && !is_wp_error($specialities))
        @foreach(array_slice($specialities, 0, 1) as $speciality)
        <span class="text-[10px] font-bold text-[var(--color-primary)] bg-[var(--color-primary-soft)] px-2.5 py-1 rounded-md uppercase tracking-wider">
          {{ $speciality->name }}
        </span>
        @endforeach
        @endif
      </div>
    </div>

    <div class="mb-5">
      <h3 class="text-xl font-bold text-[var(--color-text-primary)] mb-2 group-hover:text-[var(--color-primary)] transition-colors leading-tight">
        <a href="{{ get_permalink($doctor->ID) }}">
          {{ $doctor->post_title }}
        </a>
      </h3>
      <div class="flex flex-col lg:flex-row gap-2 lg:gap-4 my-2 lg:my-4">
        @if($location)
        <div class="flex items-start text-[var(--color-text-secondary)] text-sm leading-relaxed">
          <svg class="w-4 h-4 mr-2 mt-0.5 shrink-0 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          </svg>
          {{ $location }}
        </div>
        @endif
        @if($experience)
        <div class="flex items-start text-[var(--color-text-secondary)] text-sm leading-relaxed">
          <svg class="w-4 h-4 mr-2 mt-0.5 shrink-0 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path d="M6.5,17h9.55c0.245,1.694,1.688,3,3.45,3s3.205-1.306,3.45-3h2.55c1.223,0,2.239-0.884,2.454-2.046
	C29.67,14.729,31,13.277,31,11.5s-1.33-3.229-3.046-3.454C27.739,6.884,26.723,6,25.5,6h-6.55c-0.245-1.694-1.688-3-3.45-3
	s-3.205,1.306-3.45,3H9.95C9.705,4.306,8.262,3,6.5,3C4.567,3,3,4.567,3,6.5S4.567,10,6.5,10c1.762,0,3.205-1.306,3.45-3h2.101
	c0.245,1.694,1.688,3,3.45,3s3.205-1.306,3.45-3h6.55c0.672,0,1.236,0.447,1.426,1.058C25.268,8.333,24,9.764,24,11.5
	s1.268,3.167,2.926,3.442C26.736,15.553,26.172,16,25.5,16h-2.55c-0.245-1.694-1.688-3-3.45-3s-3.205,1.306-3.45,3H6.5
	c-1.223,0-2.239,0.884-2.454,2.046C2.33,18.271,1,19.723,1,21.5s1.33,3.229,3.046,3.454C4.261,26.116,5.277,27,6.5,27h2.55
	c0.245,1.694,1.688,3,3.45,3s3.205-1.306,3.45-3h6.101c0.245,1.694,1.688,3,3.45,3c1.933,0,3.5-1.567,3.5-3.5S27.433,23,25.5,23
	c-1.762,0-3.205,1.306-3.45,3H15.95c-0.245-1.694-1.688-3-3.45-3s-3.205,1.306-3.45,3H6.5c-0.672,0-1.236-0.447-1.426-1.058
	C6.732,24.667,8,23.236,8,21.5s-1.268-3.167-2.926-3.442C5.264,17.447,5.828,17,6.5,17z M6.5,8C5.673,8,5,7.327,5,6.5S5.673,5,6.5,5
	S8,5.673,8,6.5S7.327,8,6.5,8z M15.5,8C14.673,8,14,7.327,14,6.5S14.673,5,15.5,5S17,5.673,17,6.5S16.327,8,15.5,8z M26,11.5
	c0-0.827,0.673-1.5,1.5-1.5s1.5,0.673,1.5,1.5S28.327,13,27.5,13S26,12.327,26,11.5z M19.5,15c0.827,0,1.5,0.673,1.5,1.5
	S20.327,18,19.5,18S18,17.327,18,16.5S18.673,15,19.5,15z M25.5,25c0.827,0,1.5,0.673,1.5,1.5S26.327,28,25.5,28S24,27.327,24,26.5
	S24.673,25,25.5,25z M12.5,25c0.827,0,1.5,0.673,1.5,1.5S13.327,28,12.5,28S11,27.327,11,26.5S11.673,25,12.5,25z M6,21.5
	C6,22.327,5.327,23,4.5,23S3,22.327,3,21.5S3.673,20,4.5,20S6,20.673,6,21.5z" />
          </svg>
          <span>
            {{ $experience }} {{ $experience == 1 ? 'year' : 'years' }} experience
          </span>
        </div>
        @endif
      </div>
    </div>

    {{-- CTA Button --}}
    <div class="mt-auto">
      <a href="{{ get_permalink($doctor->ID) }}" class="w-full flex items-center justify-center gap-2 py-3.5 bg-[var(--color-primary)] text-white! text-md font-bold rounded-[var(--radius-pill)] shadow-[var(--shadow-button)] hover:bg-[var(--color-primary-dark)] transition-all duration-300">
        Book
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
      </a>
    </div>
  </div>
</article>
@php
$doctor_id = $doctor->ID ?? $doctor->id ?? get_the_ID();
$post_title = $doctor->post_title ?? get_the_title($doctor_id);
$permalink = get_permalink($doctor_id);

$location = carbon_get_post_meta($doctor_id, 'doctor_location');
$price = carbon_get_post_meta($doctor_id, 'doctor_price');
$specialities = get_the_terms($doctor_id, 'speciality_type');
$thumbnail = get_the_post_thumbnail_url($doctor_id, 'large');

$is_available = true;
$rating = 4.9;
$reviews_count = 124;
@endphp

<article class="bg-white rounded-[var(--radius-xl)] shadow-[var(--shadow-card)] border border-[var(--color-border-light)] overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">
  <div class="relative h-64 bg-[var(--color-surface-muted)] overflow-hidden shrink-0">
    @if($thumbnail)
    <img src="{{ $thumbnail }}" alt="{{ $post_title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
    @else
    <div class="w-full h-full flex items-center justify-center bg-[var(--color-primary-soft)]">
      <svg class="w-16 h-16 text-[var(--color-primary-light)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
    </div>
    @endif

    <div class="absolute top-4 left-4 flex flex-col gap-2">
      @if($is_available)
      <div class="flex items-center gap-1.5 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full border border-[var(--color-success)]/20 shadow-sm">
        <span class="w-2 h-2 rounded-full bg-[var(--color-success)] animate-pulse"></span>
        <span class="text-[10px] font-bold text-[var(--color-success)] uppercase tracking-wider">Available Today</span>
      </div>
      @endif
      @if($rating >= 4.8)
      <div class="flex items-center gap-1.5 bg-[var(--color-primary-dark)]/90 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10 shadow-sm">
        <svg class="w-3 h-3 text-[var(--color-accent-yellow)]" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
        <span class="text-[10px] font-bold text-white uppercase tracking-wider">Top Rated</span>
      </div>
      @endif
    </div>

    @if($price)
    <div class="absolute bottom-4 left-4 bg-[var(--color-primary-dark)] text-white px-3.5 py-1.5 rounded-lg text-sm font-bold shadow-lg">
      €{{ $price }}<span class="text-white/60 font-medium ml-1">/visit</span>
    </div>
    @endif

    <button class="absolute top-4 right-4 p-2.5 rounded-full bg-white/80 backdrop-blur-md text-[var(--color-text-muted)] hover:text-[var(--color-danger)] hover:bg-white transition-all shadow-sm">
      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
      </svg>
    </button>
  </div>

  <div class="p-6 lg:p-7 flex flex-col grow">
    <div class="flex items-center justify-between gap-4 mb-4">
      <div class="flex flex-wrap gap-2">
        @if($specialities)
        @foreach(array_slice($specialities, 0, 1) as $speciality)
        <span class="text-[10px] font-bold text-[var(--color-primary)] bg-[var(--color-primary-soft)] px-2.5 py-1 rounded-md uppercase tracking-wider">
          {{ $speciality->name }}
        </span>
        @endforeach
        @endif
      </div>
      <div class="flex items-center gap-1 bg-[var(--color-accent-yellow)]/10 px-2 py-1 rounded-md">
        <svg class="w-3.5 h-3.5 text-[var(--color-accent-yellow)]" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
        <span class="text-[11px] font-bold text-[var(--color-text-primary)]">{{ $rating }}</span>
        <span class="text-[10px] text-[var(--color-text-muted)]">({{ $reviews_count }})</span>
      </div>
    </div>

    <div class="mb-5">
      <h3 class="text-xl font-bold text-[var(--color-text-primary)] mb-2 group-hover:text-[var(--color-primary)] transition-colors leading-tight">
        <a href="{{ $permalink }}">
          {{ $post_title }}
        </a>
      </h3>
      @if($location)
      <div class="flex items-start text-[var(--color-text-secondary)] text-sm leading-relaxed">
        <svg class="w-4 h-4 mr-2 mt-0.5 shrink-0 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        {{ $location }}
      </div>
      @endif
    </div>

    <div class="grid grid-cols-2 gap-4 pt-5 mt-auto border-t border-[var(--color-border-light)] mb-6">
      <div class="flex flex-col">
        <span class="text-[10px] font-bold text-[var(--color-text-muted)] uppercase tracking-wider mb-1">Experience</span>
        <span class="text-sm font-bold text-[var(--color-text-primary)]">12+ Years</span>
      </div>
      <div class="flex flex-col">
        <span class="text-[10px] font-bold text-[var(--color-text-muted)] uppercase tracking-wider mb-1">Patients</span>
        <span class="text-sm font-bold text-[var(--color-text-primary)]">2,500+</span>
      </div>
    </div>

    <a href="{{ $permalink }}" class="w-full flex items-center justify-center gap-2 py-3.5 bg-[var(--color-primary)] text-white text-sm font-bold rounded-[var(--radius-pill)] shadow-[var(--shadow-button)] hover:bg-[var(--color-primary-dark)] transition-all duration-300">
      Book Appointment
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
      </svg>
    </a>
  </div>
</article>
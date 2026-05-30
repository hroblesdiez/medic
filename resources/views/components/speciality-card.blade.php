<a
  href="{{ get_permalink($id) }}"
  class="speciality-card">

  {{-- ICON --}}
  <div class="w-20 h-20 mb-6 flex items-center justify-center">

    <img
      src="{{ wp_get_attachment_image_url($icon, 'full') }}"
      alt="{{ $title }}"
      class="w-full h-full object-contain">

  </div>

  {{-- TITLE --}}
  <h3 class="text-xl font-semibold text-slate-900 mb-3">
    {{ $title }}
  </h3>

  {{-- CTA --}}
  <div class="mt-auto pt-4">

    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M9 5l7 7-7 7" />
    </svg>

  </div>

</a>
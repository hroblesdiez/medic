@props(['id', 'title', 'icon', 'authorId' => null])

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

  {{-- AUTHOR PHOTO --}}
  @if($authorId)
  @php
  $authorPhoto = carbon_get_user_meta($authorId, 'author_photo') ?: get_user_meta($authorId, 'author_photo', true);
  if (!$authorPhoto) {
      $authorPhoto = Vite::asset('resources/images/authors/author1.png');
  }
  @endphp
  <div class="mb-4">
      <img src="{{ $authorPhoto }}" alt="{{ get_the_author_meta('display_name', $authorId) }}" class="w-10 h-10 rounded-full object-cover">
  </div>
  @endif

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
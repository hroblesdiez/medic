@props(['authorId'])

@php
  $authorPhoto = carbon_get_user_meta($authorId, 'author_photo');
  $displayName = get_the_author_meta('display_name', $authorId);
  $description = get_the_author_meta('description', $authorId);

  // Fallback if no photo is uploaded
  if (!$authorPhoto) {
      $authorPhoto = Vite::asset('resources/images/authors/author1.png');
  }
@endphp

<div class="bg-white rounded-xl p-8 border border-border-light shadow-sm">
  <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
    <img src="{{ $authorPhoto }}" alt="{{ $displayName }}" class="w-24 h-24 rounded-full object-cover shrink-0 shadow-md">

    <div class="text-center sm:text-left">
      <span class="text-xs font-bold text-primary uppercase tracking-widest mb-2 block">About the Author</span>
      <h3 class="text-xl font-bold text-(--color-text-primary) mb-3!">{{ $displayName }}</h3>
      <p class="text-text-secondary leading-relaxed">{{ $description }}</p>
    </div>
  </div>
</div>
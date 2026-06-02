@props(['post', 'authorId' => null])

@php
$authorId = $authorId ?? $post->post_author;
$authorPhoto = carbon_get_user_meta($authorId, 'author_photo');

// Fallback if no photo is uploaded
if (!$authorPhoto) {
  $authorPhoto = Vite::asset('resources/images/authors/author1.png');
}
@endphp

<div class="flex items-center gap-4">
  <div class="flex items-center gap-2">
    <img src="{{ $authorPhoto }}" alt="{{ get_the_author_meta('display_name', $authorId) }}" class="w-6 h-6 rounded-full object-cover">
    <span class="text-text-secondary text-xs font-semibold">{{ get_the_author_meta('display_name', $authorId) }}</span>
  </div>

  <span class="w-1 h-1 rounded-full bg-border"></span>

  <time class="text-text-muted text-xs font-medium" datetime="{{ get_post_time('c', true, $post) }}">
    {{ get_the_date('', $post) }}
  </time>

  <span class="w-1 h-1 rounded-full bg-border"></span>

  <x-blog.reading-time :content="$post->post_content" />
</div>
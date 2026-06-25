@props(['content'])

@php
  $wordCount = str_word_count(strip_tags($content));
  $readingTime = ceil($wordCount / 200);
@endphp

<span class="flex items-center gap-1.5 text-[var(--color-text-muted)] text-xs font-medium">
  <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  {{ $readingTime }} min read
</span>

@props(['tag'])

@if($tag)
  <a href="{{ get_term_link($tag) }}" class="inline-flex items-center px-3 py-1 rounded-full bg-[var(--color-primary-soft)] text-[var(--color-primary)] text-xs font-bold transition-all hover:bg-[var(--color-primary)] hover:text-white uppercase tracking-wider">
    {{ $tag->name }}
  </a>
@endif

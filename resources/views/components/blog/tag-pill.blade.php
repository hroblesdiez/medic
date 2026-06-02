@props(['tag'])

@if($tag)
<a href="{{ get_term_link($tag) }}" class="inline-flex items-center px-3 py-1 rounded-full bg-primary-soft text-primary text-xs font-bold transition-all hover:bg-primary hover:text-white! uppercase tracking-wider">
  {{ $tag->name }}
</a>
@endif
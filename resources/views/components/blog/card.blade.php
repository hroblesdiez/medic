@props(['post'])

<article @php(post_class('group bg-white rounded-[var(--radius-xl)] border border-[var(--color-border-light)] shadow-[var(--shadow-card-soft)] overflow-hidden transition-all duration-500 hover:shadow-[var(--shadow-card-hover)] hover:-translate-y-2', $post->ID))>
  <div class="relative aspect-[16/10] overflow-hidden">
    @if(has_post_thumbnail($post->ID))
      {!! get_the_post_thumbnail($post->ID, 'large', ['class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110']) !!}
    @else
      <div class="w-full h-full bg-[var(--color-surface-muted)] flex items-center justify-center">
        <svg class="w-12 h-12 text-[var(--color-border)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    @endif

    <div class="absolute top-4 left-4 z-10">
      @php($tags = get_the_tags($post->ID))
      @if($tags)
        <x-blog.tag-pill :tag="$tags[0]" />
      @endif
    </div>
  </div>

  <div class="p-6 lg:p-8">
    <div class="mb-4">
      <x-blog.meta :post="$post" />
    </div>

    <h3 class="text-xl lg:text-2xl font-bold text-[var(--color-text-primary)] mb-4 line-clamp-2 leading-tight transition-colors group-hover:text-[var(--color-primary)]">
      <a href="{{ get_permalink($post->ID) }}">
        {!! get_the_title($post->ID) !!}
      </a>
    </h3>

    <div class="text-[var(--color-text-secondary)] text-sm lg:text-base leading-relaxed line-clamp-3 mb-6">
      {!! get_the_excerpt($post->ID) !!}
    </div>

    <a href="{{ get_permalink($post->ID) }}" class="inline-flex items-center text-[var(--color-primary)] text-sm font-bold gap-2 group/link">
      Read Article
      <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
      </svg>
    </a>
  </div>
</article>

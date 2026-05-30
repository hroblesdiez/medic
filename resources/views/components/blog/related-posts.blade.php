@props(['currentPostId'])

@php
  $args = [
      'post_type' => 'post',
      'posts_per_page' => 3,
      'post__not_in' => [$currentPostId],
      'orderby' => 'rand',
  ];
  $related = new WP_Query($args);
@endphp

@if($related->have_posts())
  <section class="mt-20 pt-20 border-t border-[var(--color-border-light)]">
    <div class="flex items-center justify-between mb-10">
      <h2 class="text-2xl lg:text-3xl font-bold text-[var(--color-text-primary)]">Related Articles</h2>
      <a href="{{ get_post_type_archive_link('post') }}" class="text-[var(--color-primary)] font-bold text-sm hover:underline">View All</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($related->posts as $post)
        <x-blog.card :post="$post" />
      @endforeach
    </div>
  </section>
@endif

@php(wp_reset_postdata())

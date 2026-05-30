@props(['post'])

<div class="flex items-center gap-4">
  <div class="flex items-center gap-2">
    @php($authorId = $post->post_author)
    <img src="{{ get_avatar_url($authorId) }}" alt="{{ get_the_author_meta('display_name', $authorId) }}" class="w-6 h-6 rounded-full object-cover">
    <span class="text-[var(--color-text-secondary)] text-xs font-semibold">{{ get_the_author_meta('display_name', $authorId) }}</span>
  </div>
  
  <span class="w-1 h-1 rounded-full bg-[var(--color-border)]"></span>
  
  <time class="text-[var(--color-text-muted)] text-xs font-medium" datetime="{{ get_post_time('c', true, $post) }}">
    {{ get_the_date('', $post) }}
  </time>

  <span class="w-1 h-1 rounded-full bg-[var(--color-border)]"></span>

  <x-blog.reading-time :content="$post->post_content" />
</div>

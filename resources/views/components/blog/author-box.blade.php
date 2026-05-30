@props(['authorId'])

<div class="bg-white rounded-[var(--radius-xl)] p-8 border border-[var(--color-border-light)] shadow-sm">
  <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
    <img src="{{ get_avatar_url($authorId) }}" alt="{{ get_the_author_meta('display_name', $authorId) }}" class="w-24 h-24 rounded-full object-cover shrink-0 shadow-md">
    
    <div class="text-center sm:text-left">
      <span class="text-xs font-bold text-[var(--color-primary)] uppercase tracking-widest mb-2 block">About the Author</span>
      <h3 class="text-xl font-bold text-[var(--color-text-primary)] mb-3">{{ get_the_author_meta('display_name', $authorId) }}</h3>
      <p class="text-[var(--color-text-secondary)] leading-relaxed">{{ get_the_author_meta('description', $authorId) }}</p>
    </div>
  </div>
</div>

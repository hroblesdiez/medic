<div class="flex flex-col items-center justify-center py-20 lg:py-32 text-center bg-white rounded-[var(--radius-2xl)] border border-[var(--color-border-light)] shadow-sm px-6">
  <div class="w-20 h-20 bg-[var(--color-surface-soft)] rounded-full flex items-center justify-center mb-6">
    <svg class="w-10 h-10 text-[var(--color-text-muted)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 4v4h4" />
    </svg>
  </div>
  
  <h3 class="text-2xl font-bold text-[var(--color-text-primary)] mb-3">No articles found</h3>
  <p class="text-[var(--color-text-secondary)] max-w-md mx-auto mb-8">
    We couldn't find any articles at the moment. Please check back later or try searching for something else.
  </p>

  <a href="{{ home_url('/') }}" class="inline-flex items-center px-6 py-3 bg-[var(--color-primary)] rounded-[var(--radius-pill)] text-sm font-bold text-white shadow-[var(--shadow-button)] hover:bg-[var(--color-primary-dark)] transition-all">
    Back to Home
  </a>
</div>

<div x-show="page < maxPages" class="mt-16 flex justify-center">
  <button @click="loadMore()" :disabled="loading" class="group px-10 py-4 bg-[var(--color-primary)] rounded-[var(--radius-pill)] text-sm font-bold text-white shadow-[var(--shadow-button)] hover:bg-[var(--color-primary-dark)] transition-all flex items-center gap-3 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
    <template x-if="loading">
      <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
    </template>
    <span x-text="loading ? 'Loading...' : 'Load more articles'"></span>
  </button>
</div>

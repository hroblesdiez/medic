<div class="col-span-full py-20 text-center">
  <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 rounded-full mb-6">
    <svg class="w-10 h-10 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
  </div>
  <h3 class="text-xl font-bold text-gray-900 mb-2">No doctors found</h3>
  <p class="text-gray-500 max-w-xs mx-auto">We couldn't find any doctors matching your current filters. Try adjusting your search or filters.</p>
  <button @click="resetFilters()" class="mt-6 text-blue-600 font-semibold hover:text-blue-700 transition-colors">
    Clear all filters
  </button>
</div>

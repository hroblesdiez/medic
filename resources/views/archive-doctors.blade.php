@extends('layouts.app')

@section('content')
<div class="bg-surface-soft min-h-screen py-2 lg:py-6"
  x-data="doctorFilter({
        initialSpeciality: '{{ $current_speciality ?? '' }}',
        maxPrice: {{ $max_price ?? 500 }},
        initialMaxPages: {{ $max_pages ?? 1 }},
        initialCount: {{ count($doctors ?? []) }},
        apiUrl: '{{ esc_url(rest_url('medic/v1/doctors')) }}'
     })"
  x-init="hasFiltered = false">
  <div class="grow mx-auto px-4 max-w-width">

    <header class="mb-4 lg:mb-6">
      <div class="flex flex-col md:flex-row md:items-end justify-end gap-6">

        <div class="bg-white px-5 py-1 py-2 rounded-[var(--radius-lg)] border border-[var(--color-border-light)] shadow-sm self-start md:self-end">
          <span class="text-[var(--color-text-secondary)] text-sm font-medium">Results:</span>
          <span class="text-[var(--color-text-primary)] font-bold ml-1" x-text="foundPosts"></span>
          <span class="text-[var(--color-text-muted)] text-sm font-medium ml-1">specialists</span>
        </div>
      </div>
    </header>

    <div class="flex flex-col lg:flex-row gap-10">

      <aside class="w-full lg:w-[320px] shrink-0">
        <div class="bg-white rounded-[var(--radius-xl)] p-8 shadow-[var(--shadow-card)] border border-[var(--color-border-light)] sticky top-28">
          <div class="flex items-center justify-between mb-8 border-b border-[var(--color-border-light)] pb-5">
            <h3 class="text-lg font-bold text-[var(--color-text-primary)] flex items-center gap-2">
              Filter
            </h3>
            <button @click="resetFilters()" class="text-xs font-bold text-[var(--color-primary)] hover:text-[var(--color-primary-dark)] transition-colors  tracking-wider">Reset All</button>
          </div>

          <div class="mb-10">
            <h4 class=" text-text-muted mb-5!">Specialities</h4>
            <div class="space-y-4 pr-2 custom-scrollbar">
              <label class="flex items-center group cursor-pointer">
                <div class="relative flex items-center">
                  <input type="radio" name="speciality" value="" x-model="filters.speciality" @change="filter()" class="peer appearance-none w-5 h-5 border-2 border-[var(--color-border)] rounded-md checked:bg-[var(--color-primary)] checked:border-[var(--color-primary)] transition-all cursor-pointer">
                  <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 left-[3px] pointer-events-none transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <span class="ml-3 text-sm font-medium text-[var(--color-text-secondary)] group-hover:text-[var(--color-text-primary)] transition-colors">All Categories</span>
              </label>
              @foreach($specialities as $speciality)
              <label class="flex items-center group cursor-pointer">
                <div class="relative flex items-center">
                  <input type="radio" name="speciality" value="{{ $speciality->term_id }}" x-model="filters.speciality" @change="filter()" class="peer appearance-none w-5 h-5 border-2 border-[var(--color-border)] rounded-md checked:bg-[var(--color-primary)] checked:border-[var(--color-primary)] transition-all cursor-pointer">
                  <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 left-[3px] pointer-events-none transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <span class="ml-3 text-sm font-medium text-[var(--color-text-secondary)] group-hover:text-[var(--color-text-primary)] transition-colors">{{ $speciality->name }}</span>
              </label>
              @endforeach
            </div>
          </div>

          <div class="mb-10">
            <div class="flex items-center justify-between mb-5">
              <h4 class=" text-text-muted mb-5!">Pricing</h4>
              <span class="text-sm font-bold text-[var(--color-primary)]">Max (PLN) <span x-text="filters.price"></span></span>
            </div>
            <div class="px-1">
              <input type="range" min="0" :max="maxPrice" step="10" x-model="filters.price" @input.debounce.250ms="filter()" class="w-full h-1.5 bg-[var(--color-primary-soft)] rounded-lg appearance-none cursor-pointer accent-[var(--color-primary)]">
            </div>
          </div>

          <div>
            <h4 class=" text-text-muted mb-5!">Location</h4>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[var(--color-text-muted)]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
              </span>
              <input type="text" x-model="filters.location" @input.debounce.500ms="filter()" placeholder="Enter city or clinic..." class="block w-full pl-11 pr-4 py-3.5 border border-[var(--color-border)] rounded-[var(--radius-lg)] bg-[var(--color-surface-muted)] text-sm font-medium focus:outline-none focus:bg-white focus:ring-2 focus:ring-[var(--color-primary-soft)] transition-all">
            </div>
          </div>
        </div>
      </aside>

      <main class="grow">
        <div class="relative min-h-[400px]">

          <div x-show="loading" x-transition.opacity class="absolute inset-0 bg-[var(--color-surface-soft)]/60 backdrop-blur-[1px] z-20 flex items-start justify-center pt-20">
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-[var(--color-border-light)] flex items-center gap-4">
              <div class="w-6 h-6 border-3 border-[var(--color-primary-soft)] border-t-[var(--color-primary)] rounded-full animate-spin"></div>
              <span class="text-sm font-bold">Searching...</span>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <template x-if="!hasFiltered">
              <div class="contents">
                @foreach($doctors as $doctor)
                @include('partials.doctor-card', ['doctor' => $doctor])
                @endforeach
              </div>
            </template>

            <template x-if="hasFiltered">
              <div class="contents" x-html="resultsHtml"></div>
            </template>
          </div>

          <div x-show="hasFiltered && foundPosts === 0" class="flex flex-col items-center justify-center py-20 text-center">
            <h3 class="text-xl font-bold text-[var(--color-text-primary)] mb-2">We couldn't find doctors.</h3>
            <p class="text-[var(--color-text-secondary)]">Try filtering again.</p>
          </div>

          <div x-show="page < maxPages" class="mt-16 flex justify-center">
            <button @click="loadMore()" :disabled="loading" class="group px-10 py-4 bg-[var(--color-primary)] rounded-[var(--radius-pill)] text-sm font-bold text-white shadow-[var(--shadow-button)] hover:bg-[var(--color-primary-dark)] transition-all flex items-center gap-3">
              <span x-text="loading ? 'Loading...' : 'See more specialists'"></span>
            </button>
          </div>
        </div>
      </main>
    </div>
  </div>
</div>
@endsection
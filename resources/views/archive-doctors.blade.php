@extends('layouts.app')

@section('content')
<div class="doctors-archive"
  x-data="doctorFilter({
        initialSpeciality: '{{ $current_speciality ?? '' }}',
        maxPrice: {{ $max_price ?? 500 }},
        initialMaxPages: {{ $max_pages ?? 1 }},
        initialCount: {{ count($doctors ?? []) }},
        apiUrl: '{{ esc_url(rest_url('medic/v1/doctors')) }}'
     })"
  x-init="hasFiltered = false">

  <div class="doctors-archive__container">

    <header class="doctors-archive__header">
      <div>
        <h1 class="text-3xl font-bold text-secondary">Find a Doctor</h1>
        <p class="text-slate-500 mt-1">Book your appointment with our specialists</p>
      </div>

      <div class="doctors-archive__results-badge">
        <span class="text-slate-500 text-sm font-medium">Results:</span>
        <span class="text-secondary font-bold" x-text="foundPosts"></span>
        <span class="text-slate-400 text-sm font-medium">specialists</span>
      </div>
    </header>

    <div class="doctors-archive__main-grid">

      <aside class="doctors-filter">
        <div class="doctors-filter__card">
          <div class="doctors-filter__header">
            <h3 class="text-lg font-bold text-secondary flex items-center gap-2">
              Filter Options
            </h3>
            <button @click="resetFilters()" class="text-xs font-bold text-primary hover:text-primary-dark transition-colors tracking-wider">Reset All</button>
          </div>

          <div class="doctors-filter__section">
            <h4 class="doctors-filter__section-title">Specialities</h4>
            <div class="pr-2 custom-scrollbar max-h-60 overflow-y-auto">
              <label class="filter-option group">
                <div class="relative flex items-center">
                  <input type="radio" name="speciality" value="" x-model="filters.speciality" @change="filter()" class="filter-option__input peer">
                  <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 left-[3px] pointer-events-none transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <span class="filter-option__label">All Categories</span>
              </label>

              @foreach($specialities as $speciality)
              <label class="filter-option group">
                <div class="relative flex items-center">
                  <input type="radio" name="speciality" value="{{ $speciality->term_id }}" x-model="filters.speciality" @change="filter()" class="filter-option__input peer">
                  <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 left-[3px] pointer-events-none transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <span class="filter-option__label">{{ $speciality->name }}</span>
              </label>
              @endforeach
            </div>
          </div>

          <div class="doctors-filter__section">
            <div class="flex items-center justify-between mb-2">
              <h4 class="doctors-filter__section-title !mb-0">Pricing</h4>
              <span class="text-sm font-bold text-primary">Max: <span x-text="filters.price"></span> PLN</span>
            </div>
            <input type="range" min="0" :max="maxPrice" step="10" x-model="filters.price" @input.debounce.250ms="filter()" class="filter-range">
          </div>

          <div class="doctors-filter__section !mb-0">
            <h4 class="doctors-filter__section-title">Location</h4>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
              </span>
              <input type="text" x-model="filters.location" @input.debounce.500ms="filter()" placeholder="Enter city or clinic..." class="block w-full pl-11 pr-4 py-3.5 border border-slate-200 rounded-xl bg-slate-50 text-sm font-medium focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary-soft transition-all">
            </div>
          </div>
        </div>
      </aside>

      <main class="doctors-results">
        <div x-show="loading" x-transition.opacity class="doctors-results__loading">
          <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
            <div class="w-6 h-6 border-3 border-primary-soft border-t-primary rounded-full animate-spin"></div>
            <span class="text-sm font-bold">Searching...</span>
          </div>
        </div>

        <div class="doctors-results__grid">
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

        <div x-show="hasFiltered && foundPosts === 0" class="doctors-results__empty">
          <h3 class="text-xl font-bold text-secondary mb-2">We couldn't find doctors.</h3>
          <p class="text-slate-500">Try adjusting your filters.</p>
        </div>

        <div x-show="page < maxPages" class="mt-16 flex justify-center">
          <button
            @click="loadMore()"
            :disabled="loading"
            class="px-10 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
            <span x-text="loading ? 'Loading...' : 'See more specialists'"></span>
          </button>
        </div>
      </main>
    </div>
  </div>
</div>
@endsection
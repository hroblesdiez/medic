@extends('layouts.app')

@section('content')
  <div class="bg-[var(--color-surface-soft)] min-h-screen py-12 lg:py-20"
    x-data="blogLoadMore({
        initialMaxPages: {{ $max_pages ?? 1 }},
        apiUrl: '{{ $apiUrl }}'
    })">
    <div class="max-w-[var(--container-width)] mx-auto px-4">
      
      <header class="text-center mb-16 lg:mb-24">
        <h1 class="text-4xl lg:text-6xl font-bold text-[var(--color-text-primary)] mb-6">
          {!! $title !!}
        </h1>
        @if(is_home())
          <p class="text-[var(--color-text-secondary)] text-lg lg:text-xl max-w-2xl mx-auto leading-relaxed">
            Discover the latest health tips, medical research, and wellness advice from our team of professional specialists.
          </p>
        @endif
      </header>

      <div class="relative">
        @if (! have_posts())
          @include('partials.blog.empty-state')
        @else
          @include('partials.blog.grid')

          <x-blog.load-more-button />
        @endif
      </div>
    </div>
  </div>
@endsection

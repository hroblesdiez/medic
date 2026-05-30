@extends('layouts.app')

@section('content')
<div class="bg-surface-soft) min-h-screen py-12 lg:py-20"
  x-data="blogLoadMore({
        initialMaxPages: {{ $max_pages ?? 1 }},
        apiUrl: '{{ $apiUrl }}'
    })">
  <div class="max-w-width) mx-auto px-4">

    <header class="text-center mb-16 lg:mb-24">
      <h1 class="text-4xl lg:text-6xl font-bold text-color-primary)] mb-6">
        Medical <span class="text-color-primary">Insights</span>
      </h1>
      <p class="text-text-secondary text-lg lg:text-xl max-w-2xl mx-auto leading-relaxed">
        Discover the latest health tips, medical research, and wellness advice from our team of professional specialists.
      </p>
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
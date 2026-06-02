@extends('layouts.app')

@section('content')
<x-hero
  :title="get_the_title(get_option('page_for_posts'))" />
<div class="bg-surface-soft min-h-screen"
  x-data="blogLoadMore({
        initialMaxPages: {{ $max_pages ?? 1 }},
        apiUrl: '{{ $apiUrl }}'
    })">
  <div class="max-w-width mx-auto px-4 sm:px-6 lg:px-8 py-4 lg:py-8">

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
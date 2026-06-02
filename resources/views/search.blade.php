@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <section class="section-container">
    <div class="content-container">
      @if (! have_posts())
        <x-alert type="warning">
          {!! __('Sorry, no results were found.', 'sage') !!}
        </x-alert>

        <div class="mt-8 max-w-xl mx-auto">
          {!! get_search_form(false) !!}
        </div>
      @endif

      <div class="space-y-12">
        @while(have_posts()) @php(the_post())
          @include('partials.content-search')
        @endwhile
      </div>

      <div class="mt-12">
        {!! get_the_posts_navigation() !!}
      </div>
    </div>
  </section>
@endsection

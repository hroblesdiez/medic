@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <section class="section-container">
    <div class="content-container">
      @if (! have_posts())
        <x-alert type="warning">
          {!! __('Sorry, but the page you are trying to view does not exist.', 'sage') !!}
        </x-alert>

        <div class="mt-8 max-w-xl mx-auto">
          {!! get_search_form(false) !!}
        </div>
      @endif
    </div>
  </section>
@endsection

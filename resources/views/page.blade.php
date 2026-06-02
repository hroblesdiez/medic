@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    <section class="section-container">
      <div class="content-container">
        @includeFirst(['partials.content-page', 'partials.content'])
      </div>
    </section>
  @endwhile
@endsection

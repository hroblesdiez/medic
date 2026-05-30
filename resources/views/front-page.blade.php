@extends('layouts.app')

@section('content')
<x-hero
  :title="get_the_title()" />
@include('partials.home.about')
@include('partials.home.why_choose_us')
@include('partials.home.cta-banner')
@include('partials.home.best-doctors')
@include('partials.home.testimonials')
@include('partials.home.faq')
@while(have_posts()) @php(the_post())
@includeFirst(['partials.content-page', 'partials.content'])
@endwhile
@endsection
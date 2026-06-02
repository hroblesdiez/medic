@extends('layouts.app')

@section('content')
@php
$heroTitle = 'Specialities'
@endphp
<x-hero :title="$heroTitle" />

<section class="section-container">
  <div class="content-container">
    <div class="specialities-grid">
      @while(have_posts())
      @php(the_post())
      <x-speciality-card
        :id="get_the_ID()"
        :title="get_the_title()"
        :icon="carbon_get_post_meta(get_the_ID(), 'speciality_icon')" />
      @endwhile
    </div>
  </div>
</section>
@endsection
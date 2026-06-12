@extends('layouts.app')

@section('content')
<x-hero
  title="Specialities" />

<section class="section-container">
  <div class="content-container">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @php
      $specialities = get_posts([
      'post_type' => 'speciality',
      'posts_per_page' => -1,
      'orderby' => 'title',
      'order' => 'ASC'
      ]);
      @endphp
      @foreach($specialities as $speciality)
      <x-speciality-card
        :id="$speciality->ID"
        :title="$speciality->post_title"
        :icon="carbon_get_post_meta($speciality->ID, 'speciality_icon')" />
      @endforeach
    </div>
  </div>
</section>
@endsection
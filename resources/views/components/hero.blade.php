@props([
  'title',
  'subtitle' => null,
  'image' => null,
])

<section class="hero" @if($image) style="--hero-default-image: url('{{ $image }}');" @endif>
  <div class="hero__decor hero__decor--1">
    <img src="{{ Vite::asset('resources/images/elipses_about.svg') }}" alt="" aria-hidden="true">
  </div>
  <div class="hero__decor hero__decor--2">
    <img src="{{ Vite::asset('resources/images/elipses_about_2.svg') }}" alt="" aria-hidden="true">
  </div>
  <div class="hero__container">
    <h1 class="hero__title">{!! $title !!}</h1>
    @if($subtitle)
      <p class="hero__subtitle">{{ $subtitle }}</p>
    @endif
  </div>
</section>

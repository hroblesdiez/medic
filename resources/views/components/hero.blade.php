@props([
  'title',
  'subtitle' => null,
  'image' => null,
])

<section class="hero" @if($image) style="--hero-default-image: url('{{ $image }}');" @endif>
  <div class="hero__container">
    <h1 class="hero__title">{!! $title !!}</h1>
    @if($subtitle)
      <p class="hero__subtitle">{{ $subtitle }}</p>
    @endif
  </div>
</section>

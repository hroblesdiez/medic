@props([
'title',
'subtitle' => null,
'image' => null,
])

<section
  class="hero"
  style="background-image: url('{{ $image ?? $defaultHeroImage }}'); background-size: cover;">



  <div class="flex flex-row justify-center gap-2 sm:gap-4 py-8 sm:py-14">

    <h1>{{ $title }}</h1>

    @if($subtitle)
    <p>{{ $subtitle }}</p>
    @endif

  </div>

</section>
@props([
'icon',
'title',
'description',
])

<div
  class="rounded-md bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-2 hover:shadow-xl">

  <!-- ICON -->
  <div
    class="mb-6 flex h-16 w-16 items-center justify-center">

    <img
      src="{{ Vite::asset('resources/images/' . $icon) }}"
      alt="{{ $title }}">

  </div>

  <!-- TITLE -->
  <h5 class="mb-4 text-xl font-bold text-slate-900">
    {{ $title }}
  </h5>

  <!-- DESCRIPTION -->
  <p class="leading-7 text-slate-600">
    {{ $description }}
  </p>

</div>
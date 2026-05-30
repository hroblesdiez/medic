@props([
'href' => '#',
'variant' => 'primary',
'size' => 'md',
'icon' => true,
])

@php

$baseClasses = '
inline-flex items-center justify-center gap-3
rounded-full
font-semibold
transition duration-300
focus:outline-none
max-w-50
';

$variants = [
'primary' => '
bg-primary
text-white!
hover:bg-primary-dark
',

'secondary' => '
bg-primary-soft
text-primary
hover:bg-primary
hover:text-white
',

'outline' => '
border border-primary
text-primary
hover:bg-primary
hover:text-white
',

'white' => '
bg-white
text-slate-900
hover:bg-slate-100
',
];

$sizes = [
'sm' => 'px-4 py-2 text-sm',
'md' => 'px-6 py-3 text-base',
'lg' => 'px-8 py-4 text-lg',
];

@endphp

<a
  href="{{ $href }}"
  {{ $attributes->merge([
    'class' =>
      $baseClasses .
      ' ' .
      $variants[$variant] .
      ' ' .
      $sizes[$size]
  ]) }}>

  @if($icon)

  <img
    class="h-5 w-5 shrink-0"
    src="{{ Vite::asset('resources/images/user-tick.svg') }}"
    alt="Icon">

  @endif

  <span>
    {{ $slot }}
  </span>

</a>
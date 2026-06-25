@props([
'href' => '#',
'variant' => 'primary',
'size' => 'md',
'icon' => true,
])

@php
$variantClasses = [
'primary' => 'btn-primary',
'secondary' => 'btn-secondary',
'outline' => 'btn-outline',
'white' => 'btn-white',
];

$sizeClasses = [
'sm' => 'btn-sm',
'md' => 'btn-md',
'lg' => 'btn-lg',
];

$classes = 'btn ' . ($variantClasses[$variant] ?? 'btn-primary') . ' ' . ($sizeClasses[$size] ?? 'btn-md');
@endphp

<a
  href="{{ $href }}"
  {{ $attributes->merge(['class' => $classes]) }}>

  @if($icon)
  <img
    class="h-5 w-5 shrink-0"
    src="{{ Vite::asset('resources/images/user-tick.svg') }}"
    alt="" aria-hidden="true">
  @endif

  <span>
    {{ $slot }}
  </span>

</a>
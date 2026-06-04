<header
  x-data="menu()"
  class="main-header">

  <div class="main-header__container">

    <div class="main-header__inner">

      {{-- Logo --}}
      <a href="{{ home_url('/') }}" class="relative z-50 shrink-0">
        @if($logo)
        <img
          src="{{ $logo }}"
          alt="{{ $siteName }}"
          class="h-12 w-auto">
        @else
        <span class="text-2xl font-bold text-secondary">
          {{ $siteName }}
        </span>
        @endif
      </a>

      {{-- Desktop Navigation --}}
      <nav class="nav-desktop">
        {!! $menu !!}
      </nav>

      {{-- Right Side --}}
      <div class="flex items-center gap-4">

        {{-- CTA --}}
        <x-button
          href="{{ $cta['url'] }}"
          variant="primary"
          size="md"
          class="z-50 max-w-none">
          <span class="md:hidden">{{ $cta['text'][1] }}</span>
          <span class="hidden md:inline">{{ $cta['text'][0] }}</span>
        </x-button>

        {{-- Hamburger --}}
        <button
          @click="toggleMenu"
          :aria-expanded="open"
          :class="{ 'is-active': open }"
          class="hamburger group relative z-50 flex h-10 w-10 items-center justify-center lg:hidden"
          aria-label="Menu">

          <div class="hamburger-icon">
            <span class="hamburger-icon__bar-v"></span>
            <span class="hamburger-icon__bar-h"></span>
          </div>

        </button>

      </div>

    </div>

  </div>

  {{-- Mobile Navigation Overlay --}}
  <nav
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="mobile-menu"
    :class="{ 'is-open': open }">

    {!! $menu !!}

  </nav>

</header>
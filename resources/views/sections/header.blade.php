<header
  x-data="menu()"
  class="main-header">

  <div class="main-header__container">

    <div class="main-header__inner">

      {{-- Logo --}}
      <a href="{{ home_url('/') }}" class="relative z-50">
        @if($logo)
        <img
          src="{{ $logo }}"
          alt="{{ $siteName }}"
          class="main-header__logo">
        @else
        <span class="text-xl font-bold text-secondary lg:text-2xl">
          {{ $siteName }}
        </span>
        @endif
      </a>

      {{-- Desktop Navigation --}}
      <nav class="nav-desktop">
        {!! $menu !!}
      </nav>

      {{-- Right Side --}}
      <div class="main-header__actions">

        {{-- CTA compact: visible below sm, shows only the short label --}}
        <x-button
          href="{{ $cta['url'] }}"
          variant="primary"
          size="md"
          class="main-header__cta main-header__cta--compact z-50">
          {{ $cta['text'][1] }}
        </x-button>

        {{-- CTA full: visible from sm upwards --}}
        <x-button
          href="{{ $cta['url'] }}"
          variant="primary"
          size="md"
          class="main-header__cta main-header__cta--full z-50">
          {{ $cta['text'][0] }}
        </x-button>

        {{-- Hamburger --}}
        <button
          @click="toggleMenu()"
          :aria-expanded="open"
          :class="{ 'is-active': open }"
          class="hamburger"
          aria-label="Menu">

          <div class="hamburger-icon">
            <span class="hamburger-icon__bar-v"></span>
            <span class="hamburger-icon__bar-h"></span>
          </div>

        </button>

      </div>

    </div>

  </div>

  {{-- Mobile Navigation --}}
  <nav
    :class="{ 'is-open': open }"
    @click="closeMenu()"
    class="mobile-menu">

    {!! $menu !!}

  </nav>

</header>
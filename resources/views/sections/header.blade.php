<header
  x-data="menu()"
  class="relative border-b border-slate-200">

  <div class="container mx-auto">

    <div class="flex items-center justify-between px-4 py-6">

      {{-- Logo --}}
      <a href="{{ home_url('/') }}" class="relative z-50 shrink-0">

        @if($logo)
        <img
          src="{{ $logo }}"
          alt="{{ $siteName }}"
          class="h-12 w-auto">
        @else
        <span class="text-2xl font-bold">
          {{ $siteName }}
        </span>
        @endif

      </a>

      {{-- Desktop Navigation --}}
      <nav class="hidden lg:flex">
        {!! $menu !!}
      </nav>

      {{-- Right Side --}}
      <div class="flex items-center gap-3">

        {{-- CTA --}}
        <a
          href="{{ $cta['url'] }}"
          class="z-50 flex items-center justify-center text-center rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 lg:px-6 lg:py-3 lg:text-base">
          <span class="md:hidden">
            {{ $cta['text'][1] }}
          </span>

          <span class="hidden md:inline">
            {{ $cta['text'][0] }}
          </span>
        </a>

        {{-- Hamburger --}}
        <button
          @click="toggleMenu"
          :aria-expanded="open"
          :class="{ 'is-active': open }"
          class="hamburger group relative z-50 flex h-10 w-10 items-center justify-center lg:hidden"
          aria-label="Menu">

          <div class="relative h-6 w-6 transition-transform duration-300 group-[.is-active]:rotate-45">

            {{-- Vertical Bar --}}
            <span
              class="absolute left-1/2 top-0 h-full w-1 bg-blue-600 transition-all duration-300 -translate-x-1/2 group-[.is-active]:h-1 group-[.is-active]:top-1/2 group-[.is-active]:-translate-y-1/2 group-[.is-active]:w-full"></span>

            {{-- Horizontal Bar --}}
            <span
              class="absolute left-0 top-1/2 h-1 w-full bg-blue-600 transition-all duration-300 -translate-y-1/2"></span>

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
    class="mobile-menu lg:hidden"
    :class="{ 'is-open': open }">

    {!! $menu !!}

  </nav>

</header>
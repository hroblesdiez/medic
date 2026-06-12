<!doctype html>
<html {!! get_language_attributes() !!}>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php do_action('get_header'); @endphp
  @php wp_head(); @endphp

  @vite(['resources/css/app.css','resources/js/app.js'])

  @if(!empty($defaultHeroImage))
  <style>
    :root {
      --hero-default-image: url('{{ $defaultHeroImage }}');
    }
  </style>
  @endif

  @php
  $gaId = env('GOOGLE_ANALYTICS_ID');
  @endphp

  @if($gaId)
  <meta name="ga-id" data-ga-id="{{ esc_attr($gaId) }}">
  <script>
    document.documentElement.dataset.gaId = '{{ esc_attr($gaId) }}';
  </script>
  @endif
</head>

<body @php(body_class())>
  @php(wp_body_open())

  <div id="app">
    <a class="sr-only focus:not-sr-only" href="#main">
      {{ __('Skip to content', 'sage') }}
    </a>

    @include('sections.header')

    <main id="main" class="main">
      @yield('content')
    </main>

    @hasSection('sidebar')
    <aside class="sidebar">
      @yield('sidebar')
    </aside>
    @endif

    @include('sections.footer')
  </div>

  @php(do_action('get_footer'))
  @php(wp_footer())

</body>

</html>
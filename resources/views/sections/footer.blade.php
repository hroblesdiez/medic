<footer class="main-footer">

  <div class="main-footer__container">

    {{-- GRID SUPERIOR --}}
    <div class="main-footer__grid">

      <div class="main-footer__menu">
        <h4 class="main-footer__widget-title">Company</h4>
        {!! $companyMenu !!}
      </div>

      <div class="main-footer__menu">
        <h4 class="main-footer__widget-title">Treatments</h4>
        {!! $treatmentsMenu !!}
      </div>

      <div class="main-footer__menu">
        <h4 class="main-footer__widget-title">Specialities</h4>
        {!! $specialitiesMenu !!}
      </div>

      <div class="main-footer__menu">
        <h4 class="main-footer__widget-title">Utilities</h4>
        {!! $utilitiesMenu !!}
      </div>

      {{-- NEWSLETTER --}}
      <div class="col-span-2 lg:col-span-1">
        <h4 class="main-footer__widget-title">Newsletter</h4>

        <p class="text-sm text-slate-600 mb-3">
          Subscribe and stay updated
        </p>

        <form class="footer-newsletter__form">
          <input
            type="email"
            placeholder="Enter email address"
            class="footer-newsletter__input" />

          <x-button
            type="submit"
            size="sm"
            variant="primary"
            :icon="false">
            Send
          </x-button>
        </form>

        {{-- SOCIAL --}}
        <div class="mt-8">
          <h5 class="text-sm font-bold text-secondary mb-4">Connect With Us</h5>

          <div class="flex gap-4">
            <a href="#" class="transition-transform hover:scale-110">
              <img
                src="{{ Vite::asset('resources/images/social/facebook.svg') }}"
                alt="Facebook"
                class="w-8 h-8">
            </a>
            <a href="#" class="transition-transform hover:scale-110">
              <img
                src="{{ Vite::asset('resources/images/social/twitter.svg') }}"
                alt="X"
                class="w-8 h-8">
            </a>
          </div>
        </div>

      </div>

    </div>

    {{-- BOTTOM BAR --}}
    <div class="main-footer__bottom">

      <p>Copyright &copy; {{ date('Y') }} All rights reserved</p>

      <div class="main-footer__bottom-links">
        <a href="#">Legal Notice</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Refund Policy</a>
      </div>

    </div>

  </div>

</footer>

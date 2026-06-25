<section class="py-16 lg:py-24">

  <div class="content-container">

    <div class="cta-banner">

      <div class="cta-banner__container">

        <!-- LEFT -->
        <div class="flex flex-col max-w-xl">

          <h2 class="cta-banner__title">
            Be on Your Way to Feeling Better with the Doccure
          </h2>

          <p class="cta-banner__description">
            Be on your way to feeling better as we prioritize your health
            journey with personalized and accessible services.
          </p>

          <!-- BUTTON -->
          <div>
            <x-button
              href="/contact"
              variant="white"
              :icon="false">
              Contact With Us
            </x-button>
          </div>

        </div>

        <!-- RIGHT IMAGE -->
        <div class="cta-banner__image-wrapper">

          <img
            class="cta-banner__image"
            src="{{ Vite::asset('resources/images/banner-doctor.png') }}"
            alt="Experienced doctor ready to help you feel better with personalized care">

        </div>

      </div>

    </div>

  </div>

</section>

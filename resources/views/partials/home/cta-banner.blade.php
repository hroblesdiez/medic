<section class="py-16 lg:py-24">

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div
      class="rounded-[32px] bg-[#0E82FD] lg:max-h-112 py-4 lg:py-8">

      <!-- CONTENT -->
      <div
        class="flex flex-col lg:flex-row items-center justify-between lg:max-h-112 gap-10 px-8 lg:px-16">

        <!-- LEFT -->
        <div class="flex flex-col gap-4 lg:gap-8 max-w-xl">

          <h2
            class="mb-5 text-3xl font-bold leading-tight text-white! lg:text-5xl">
            Be on Your Way to Feeling Better with the Doccure
          </h2>

          <p
            class="mb-8 text-base leading-8 text-blue-100!">
            Be on your way to feeling better as we prioritize your health
            journey with personalized and accessible services.
          </p>

          <!-- BUTTON -->
          <x-button
            href="/contact"
            variant="white"
            :icon="false">
            Contact With Us
          </x-button>
        </div>

        <!-- RIGHT IMAGE -->
        <div class="relative flex justify-center self-end -mb-10 lg:-mb-16">

          <img
            class="relative z-10 w-full max-w-50 object-contain drop-shadow-2xl"
            src="{{ Vite::asset('resources/images/banner-doctor.png') }}"
            alt="Doctor">

        </div>

      </div>

    </div>

  </div>

</section>
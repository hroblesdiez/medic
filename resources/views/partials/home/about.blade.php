<section class="py-4 lg:py-8 overflow-hidden">

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

      <!-- LEFT IMAGES -->
      <div class="grid grid-cols-2 gap-4 lg:gap-6">

        <!-- LEFT COLUMN -->
        <div class="flex flex-col gap-4 lg:gap-6">

          <img
            class="w-full rounded-3xl object-cover aspect-4/5"
            src="{{ Vite::asset('resources/images/about_us_1.png') }}"
            alt="About Us">

          <img
            class="w-full rounded-3xl object-cover aspect-4/5"
            src="{{ Vite::asset('resources/images/about_us_2.png') }}"
            alt="About Us">

        </div>

        <!-- RIGHT COLUMN -->
        <div class="flex flex-col justify-center gap-4 lg:gap-6">

          <!-- EXPERIENCE CARD -->
          <div class="flex flex-col items-center justify-center rounded-3xl bg-primary py-2 lg:py-4 text-center">

            <p class="text-5xl font-bold text-white!">
              30+
            </p>

            <p class="mt-3 text-lg font-medium text-white!">
              Years Experience
            </p>

          </div>

          <img
            class="w-full rounded-3xl object-cover aspect-4/5"
            src="{{ Vite::asset('resources/images/about_us_3.png') }}"
            alt="About Us">

        </div>

      </div>

      <!-- RIGHT CONTENT -->
      <div class="flex flex-col">

        <span class="mb-4 inline-block text-sm font-semibold uppercase tracking-wider text-primary">
          About Our Company
        </span>

        <h2 class="mb-6 text-4xl font-bold leading-tight text-slate-900 lg:text-5xl">
          We Ensure Always The Best
        </h2>

        <p class="mb-6 text-base leading-8 text-slate-600">
          At Doccure, we understand the importance of accessible and convenient healthcare.
          Our mission is to simplify the process of finding and booking appointments with
          qualified healthcare professionals, ensuring that you receive the care you need
          when you need it.
        </p>

        <p class="mb-8 text-base leading-8 text-slate-600">
          We envision a world where healthcare is easily accessible to everyone.
          Whether you're seeking routine check-ups, specialized consultations,
          or emergency care, we strive to connect you with the right medical
          professionals effortlessly.
        </p>

        <!-- PHONE BLOCK -->
        <div class="flex items-center gap-4 lg:gap-6 mt-4 lg:mt-8">

          <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-primary-soft">

            <img
              class="h-6 w-6"
              src="{{ Vite::asset('resources/images/phone.svg') }}"
              alt="Phone">

          </div>

          <div>

            <p class="mb-1 text-sm font-medium text-slate-500">
              Need Emergency?
            </p>

            <a
              href="tel:+48152568897"
              class="text-xl font-bold text-slate-900 transition hover:text-primary">
              +48 152 568 897
            </a>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>
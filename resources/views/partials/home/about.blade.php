<section class="section-container">

  <div class="content-container">

    <div class="grid-2-cols">

      <!-- LEFT IMAGES -->
      <div class="grid grid-cols-2 gap-4 lg:gap-6">

        <!-- LEFT COLUMN -->
        <div class="flex flex-col gap-4 lg:gap-6">

          <img
            class="w-full rounded-3xl object-cover aspect-4/5"
            src="{{ Vite::asset('resources/images/about_us_1.png') }}"
            alt="Medical clinic waiting area and reception desk">

          <img
            class="w-full rounded-3xl object-cover aspect-4/5"
            src="{{ Vite::asset('resources/images/about_us_2.png') }}"
            alt="Doctor consulting with patient in modern clinic">

        </div>

        <!-- RIGHT COLUMN -->
        <div class="flex flex-col justify-center gap-4 lg:gap-6">

          <!-- EXPERIENCE CARD -->
          <div class="flex flex-col items-center justify-center rounded-3xl bg-primary py-4 text-center">

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
            alt="Medical team in consultation room">

        </div>

      </div>

      <!-- RIGHT CONTENT -->
      <div class="flex flex-col">

        <span class="section-subtitle">
          About Our Company
        </span>

        <h2 class="section-title">
          We Ensure Always The Best
        </h2>

        <p class="section-description">
          At Doccure, we understand the importance of accessible and convenient healthcare.
          Our mission is to simplify the process of finding and booking appointments with
          qualified healthcare professionals, ensuring that you receive the care you need
          when you need it.
        </p>

        <p class="section-description mb-8!">
          We envision a world where healthcare is easily accessible to everyone.
          Whether you're seeking routine check-up, specialized consultations,
          or emergency care, we strive to connect you with the right medical
          professionals effortlessly.
        </p>

        <!-- PHONE BLOCK -->
        <div class="flex items-center gap-6 mt-8">

          <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full bg-primary-soft">

          <img
            class="w-full h-full"
            src="{{ Vite::asset('resources/images/phone.svg') }}"
            alt="Phone icon for emergency contact"

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

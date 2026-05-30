<section class="testimonials-section py-12 lg:py-0">

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">

    @if($testimonials)

    <div
      class="testimonials-slider-container relative overflow-hidden"
      x-data="testimonials()"
      x-init="init()"
      @mouseenter="stopAutoplay()"
      @mouseleave="startAutoplay()">

      {{-- TRACK --}}
      <div class="testimonials-track flex transition-transform duration-700 ease-out">

        @foreach($testimonials as $testimonial)

        <div class="testimonial-slide min-w-full shrink-0">

          <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-16 w-full lg:px-8">

            {{-- LEFT: IMAGE --}}
            <div class="testimonial-image-container shrink-0">

              @if($testimonial->image)
              <img
                src="{{ $testimonial->image }}"
                alt="{{ $testimonial->name }}"
                class="mx-auto lg:mx-0">
              @else
              <div class="w-55 h-55 bg-slate-200 rounded-full mx-auto lg:mx-0"></div>
              @endif

            </div>

            {{-- RIGHT: CONTENT --}}
            <div class="grow text-center lg:text-left">

              <span class="testimonial-subtitle">
                {{ $testimonial->subtitle ?: 'Testimonials' }}
              </span>

              <h5 class="testimonial-title">
                {{ $testimonial->title ?: 'What Our Clients Say' }}
              </h5>

              <div class="testimonial-text text-lg lg:text-xl max-w-2xl">
                "{{ $testimonial->text }}"
              </div>

              <div class="mt-4">
                <p class="testimonial-author text-lg">
                  {{ $testimonial->name }}
                </p>

                <p class="testimonial-city">
                  {{ $testimonial->city }}
                </p>
              </div>

            </div>

          </div>

        </div>

        @endforeach

      </div>

      {{-- ARROWS --}}
      <button
        class="testimonial-arrow testimonial-arrow-prev"
        @click="prev()"
        aria-label="Previous testimonial">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
      </button>

      <button
        class="testimonial-arrow testimonial-arrow-next"
        @click="next()"
        aria-label="Next testimonial">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </button>

    </div>

    @endif

  </div>

</section>
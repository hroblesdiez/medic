<section class="testimonials-section">

  <div class="content-container w-full">

    @if($testimonials)

    <div class="testimonials-slider-wrapper" x-data="testimonials()" x-init="init()">
      <div
        class="testimonials-slider-container relative"
        @mouseenter="stopAutoplay()"
        @mouseleave="startAutoplay()">

        {{-- TRACK --}}
        <div class="testimonials-track flex transition-transform duration-700 ease-out">
          @foreach($testimonials as $testimonial)
          <div class="testimonial-slide min-w-full">
            <div class="flex flex-col lg:flex-row items-center gap-6 md:gap-10 lg:gap-16 w-full">
              {{-- LEFT: IMAGE --}}
              <div class="testimonial-image-container">
                @if($testimonial->image)
                <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}">
                @else
                <div class="testimonial-image-placeholder"></div>
                @endif
              </div>
              {{-- RIGHT: CONTENT --}}
              <div class="testimonial-content">
                <span class="testimonial-subtitle">{{ $testimonial->subtitle ?: 'Testimonials' }}</span>
                <h2 class="testimonial-title">{{ $testimonial->title ?: 'What Our Clients Say' }}</h2>
                <div class="testimonial-text">"{{ $testimonial->text }}"</div>
                <div class="mt-2 md:mt-4">
                  <p class="testimonial-author">{{ $testimonial->name }}</p>
                  <p class="testimonial-city">{{ $testimonial->city }}</p>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>



      </div>
      {{-- ARROWS --}}
      <button class="testimonial-arrow testimonial-arrow-prev" @click="prev()" aria-label="Previous testimonial">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
      </button>

      <button class="testimonial-arrow testimonial-arrow-next" @click="next()" aria-label="Next testimonial">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </button>
    </div>

    @endif

  </div>

</section>
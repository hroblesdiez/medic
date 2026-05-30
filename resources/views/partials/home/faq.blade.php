<section class="py-12 lg:py-30 bg-white">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-12 items-start">

      <!-- IMAGE -->
      <div class="order-2 lg:order-1 lg:sticky lg:top-24">
        <img src="{{  Vite::asset('resources/images/faq.png') }}" alt="FAQ" class="w-full h-auto rounded-2xl shadow-lg">
      </div>

      <!-- FAQ LIST -->
      <div class="order-1 lg:order-2">
        <span class="text-primary-light font-semibold uppercase mb-2 block">Get Your Answer</span>
        <h2 class="text-4xl lg:text-5xl font-bold text-secondary mb-10">Frequently Asked Questions</h2>

        <div class="space-y-4" x-data="faqComponent">
          @php
          $faqs = get_posts(['post_type' => 'faq', 'posts_per_page' => 5]);
          @endphp

          @foreach($faqs as $faq)
          <div class="bg-gray-100 rounded-sm p-4 transition-all duration-300">
            <button
              @click="toggle({{ $loop->index }})"
              class="flex justify-between items-center w-full text-left text-lg font-semibold text-secondary transition">
              {{ carbon_get_post_meta($faq->ID, 'faq_question') }}
              <span class="flex items-center justify-center w-8 h-8 bg-white rounded-[5px] text-lg font-bold" x-text="isActive({{ $loop->index }}) ? '-' : '+'"></span>
            </button>

            <div
              x-show="isActive({{ $loop->index }})"
              x-cloak
              x-collapse
              class="text-gray-600 mt-4">
              <div class="w-[95%] h-px bg-gray-200 mx-auto mb-4"></div>
              {{ carbon_get_post_meta($faq->ID, 'faq_response') }}
            </div>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</section>
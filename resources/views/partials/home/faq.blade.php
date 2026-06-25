<section class="section-container">

  <div class="content-container">

    <div class="faq-grid">

      <!-- IMAGE -->
      <div class="order-2 lg:order-1 lg:sticky lg:top-24">
        <img src="{{  Vite::asset('resources/images/faq.png') }}" alt="Frequently asked questions about our medical clinic services" class="faq-image" width="600" height="800">
      </div>

      <!-- FAQ LIST -->
      <div class="order-1 lg:order-2">

        <span class="section-subtitle">
          Get Your Answer
        </span>

        <h2 class="section-title">
          Frequently Asked Questions
        </h2>

        <div class="faq-accordion" x-data="faqComponent">
          @php
            $faqs = get_posts(['post_type' => 'faq', 'posts_per_page' => 5]);
          @endphp

          @foreach($faqs as $faq)
            <div class="faq-item">
              <button
                @click="toggle({{ $loop->index }})"
                class="faq-question">
                {{ carbon_get_post_meta($faq->ID, 'faq_question') }}
                <span class="faq-toggle" x-text="isActive({{ $loop->index }}) ? '-' : '+'"></span>
              </button>

              <div
                x-show="isActive({{ $loop->index }})"
                x-cloak
                x-collapse
                class="faq-answer">
                <div class="faq-divider"></div>
                {{ carbon_get_post_meta($faq->ID, 'faq_answer') }}
              </div>
            </div>
          @endforeach
        </div>

      </div>

    </div>

  </div>

</section>

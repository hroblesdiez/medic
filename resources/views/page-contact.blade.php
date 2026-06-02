@extends('layouts.app')

@section('content')
<x-hero
  title="Contact Us" />

<section class="contact-section" x-data="contactForm()">
  <div class="contact-container">
    <div class="contact-grid">

      {{-- Left Column: Get in Touch --}}
      <div>
        <h5 class="text-primary mb-4! lg:mb-8!">Get in Touch</h5>
        <h2 class="mb-4! lg:mb-8!">
          Have Any Question
        </h2>

        <div class="contact-details">
          {{-- Address --}}
          <div class="contact-detail-item">
            <div class="contact-detail-icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
              </svg>
            </div>
            <div class="contact-detail-content">
              <h4>Our Location</h4>
              <p>123 Medical Plaza, Health City, HC 45678</p>
            </div>
          </div>

          {{-- Phone --}}
          <div class="contact-detail-item">
            <div class="contact-detail-icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
              </svg>
            </div>
            <div class="contact-detail-content">
              <h4>Phone Number</h4>
              <p>+1 (555) 123-4567</p>
            </div>
          </div>

          {{-- Email --}}
          <div class="contact-detail-item">
            <div class="contact-detail-icon">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
              </svg>
            </div>
            <div class="contact-detail-content">
              <h4>Email Address</h4>
              <p>contact@medic.com</p>
            </div>
          </div>
        </div>
      </div>

      {{-- Right Column: Form --}}
      <div>
        <div class="contact-form-wrapper">
          {!! do_shortcode('[contact-form-7 id="365" title="Contact Page Form" html_class="contact-form"]') !!}
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  function contactForm() {
    return {
      init() {
        const form = this.$el.querySelector('form');
        if (!form) return;

        const inputs = form.querySelectorAll('input[name="your-name"], input[name="your-email"], textarea[name="your-message"]');

        inputs.forEach(input => {
          input.addEventListener('input', () => {
            this.validateInput(input);
          });

          input.addEventListener('blur', () => {
            this.validateInput(input);
          });
        });

        // Prevent XSS in inputs (basic client-side sanitization)
        form.addEventListener('submit', (e) => {
          let hasError = false;
          inputs.forEach(input => {
            if (!this.validateInput(input)) {
              hasError = true;
            }
          });

          if (hasError) {
            e.preventDefault();
          }
        });
      },

      validateInput(input) {
        let isValid = true;
        const value = input.value.trim();

        // Remove previous error class
        input.classList.remove('input-error');

        if (input.hasAttribute('aria-required') && value === '') {
          isValid = false;
        }

        if (input.type === 'email' && value !== '') {
          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(value)) {
            isValid = false;
          }
        }

        // Anti-injection: check for suspicious patterns like <script> or SQL keywords if necessary
        // Though CF7 and WP handle this backend, we can block obvious tags
        if (value.includes('<script') || value.includes('javascript:')) {
          isValid = false;
        }

        if (!isValid) {
          input.classList.add('input-error');
        }

        return isValid;
      }
    }
  }
</script>
@endsection
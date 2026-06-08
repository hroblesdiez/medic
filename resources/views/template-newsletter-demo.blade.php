{{--
Template Name: Newsletter Demo
--}}

@extends('layouts.app')

@section('content')
@php
$email = sanitize_email(request()->query('email', ''));
$validEmail = !empty($email) && is_email($email);
@endphp

<section class="newsletter-page">
  <div class="newsletter-container">

    <div class="newsletter-card">

      @if($validEmail)

      <div class="newsletter-success-icon">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M5 13l4 4L19 7" />
        </svg>
      </div>

      <h1 class="newsletter-title">
        Thanks for subscribing!
      </h1>

      <p class="newsletter-text">
        Subscription requested for:
      </p>

      <div class="newsletter-email-box">
        {{ esc_html($email) }}
      </div>

      @else

      <h1 class="newsletter-title">
        Invalid email address
      </h1>

      <p class="newsletter-text">
        Please return to the homepage and enter a valid email address.
      </p>

      @endif

      <div class="newsletter-notice">

        <h2 class="newsletter-notice-title">
          Portfolio Project Notice
        </h2>

        <p class="newsletter-notice-text">
          This newsletter feature is part of a portfolio project built with
          WordPress, Sage 11, Tailwind CSS and a Laravel-inspired architecture.
        </p>

        <p class="newsletter-notice-text--last">
          No emails are sent, no personal data is stored and your submission
          has not been recorded. The purpose of this feature is to demonstrate
          frontend and backend development capabilities.
        </p>

        <div class="newsletter-features-grid">

          <div class="newsletter-feature-item">
            ✓ Form validation
          </div>

          <div class="newsletter-feature-item">
            ✓ Accessible UI
          </div>

          <div class="newsletter-feature-item">
            ✓ Responsive design
          </div>

          <div class="newsletter-feature-item">
            ✓ Portfolio demonstration
          </div>

        </div>

        <div class="newsletter-footer">
          <a
            href="{{ home_url('/') }}"
            class="newsletter-button">
            Return to Homepage
          </a>
        </div>

      </div>

    </div>

  </div>
</section>
@endsection

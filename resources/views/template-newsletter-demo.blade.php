{{--
Template Name: Newsletter Demo
--}}

@extends('layouts.app')

@section('content')
@php
$email = sanitize_email(request()->query('email', ''));
$validEmail = !empty($email) && is_email($email);
@endphp

<section class="bg-gray-50 py-20">
  <div class="container mx-auto max-w-3xl px-6">

    <div class="rounded-2xl bg-white p-8 shadow-sm md:p-12">

      @if($validEmail)

      <div class="mb-8 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-8 w-8"
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

      <h1 class="mb-4 text-4xl font-bold">
        Thanks for subscribing!
      </h1>

      <p class="mb-6 text-lg text-gray-600">
        Subscription requested for:
      </p>

      <div class="mb-8 rounded-lg bg-gray-100 p-4 font-medium break-all">
        {{ esc_html($email) }}
      </div>

      @else

      <h1 class="mb-4 text-4xl font-bold">
        Invalid email address
      </h1>

      <p class="mb-8 text-gray-600">
        Please return to the homepage and enter a valid email address.
      </p>

      @endif

      <div class="border-t pt-8!">

        <h2 class="mb-4! text-2xl font-semibold">
          Portfolio Project Notice
        </h2>

        <p class="mb-6! text-gray-600">
          This newsletter feature is part of a portfolio project built with
          WordPress, Sage 11, Tailwind CSS and a Laravel-inspired architecture.
        </p>

        <p class="mb-8! text-gray-600">
          No emails are sent, no personal data is stored and your submission
          has not been recorded. The purpose of this feature is to demonstrate
          frontend and backend development capabilities.
        </p>

        <div class="grid gap-4 sm:grid-cols-2">

          <div class="rounded-lg border p-4">
            ✓ Form validation
          </div>

          <div class="rounded-lg border p-4">
            ✓ Accessible UI
          </div>

          <div class="rounded-lg border p-4">
            ✓ Responsive design
          </div>

          <div class="rounded-lg border p-4">
            ✓ Portfolio demonstration
          </div>

        </div>

        <div class="mt-10!">
          <a
            href="{{ home_url('/') }}"
            class="inline-flex rounded-lg bg-primary px-6 py-3 font-semibold text-white transition hover:opacity-90">
            Return to Homepage
          </a>
        </div>

      </div>

    </div>

  </div>
</section>
@endsection
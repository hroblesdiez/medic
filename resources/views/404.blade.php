@extends('layouts.app')

@section('content')
  <section class="hero">
    <div class="hero__container">
      <h1 class="hero__title">Page Not Found</h1>
      <p class="hero__subtitle mt-4 text-lg">We couldn't find the page you're looking for.</p>
    </div>
  </section>

  <section class="section-container">
    <div class="content-container max-w-2xl mx-auto text-center">
      <p class="text-slate-600 mb-8 text-lg">
        The page may have been moved, deleted, or the URL might be incorrect.
      </p>

      <div class="max-w-md mx-auto mb-12">
        {!! get_search_form(false) !!}
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-12">
        <a href="{{ home_url('/') }}" class="p-6 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition-shadow text-center">
          <span class="block text-2xl mb-2">🏠</span>
          <span class="font-bold text-secondary">Homepage</span>
        </a>
        <a href="{{ home_url('/doctors') }}" class="p-6 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition-shadow text-center">
          <span class="block text-2xl mb-2">👨‍⚕️</span>
          <span class="font-bold text-secondary">Our Doctors</span>
        </a>
        <a href="{{ home_url('/contact') }}" class="p-6 rounded-2xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition-shadow text-center">
          <span class="block text-2xl mb-2">📞</span>
          <span class="font-bold text-secondary">Contact Us</span>
        </a>
      </div>
    </div>
  </section>
@endsection

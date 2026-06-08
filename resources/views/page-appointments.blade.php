@extends('layouts.app')

@section('content')
<div class="appointments-page py-20 bg-slate-50">
  <div class="container mx-auto px-4">

    <header class="text-center max-w-3xl mx-auto mb-16">
      <h1 class="text-4xl md:text-5xl font-extrabold text-secondary leading-tight">
        Book an <span class="text-primary">Appointment</span>
      </h1>
      <p class="text-slate-500 mt-4 text-lg">
        Consult with our top specialists who contribute to our health blog. Choose your preferred expert and check their availability.
      </p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 items-stretch">
      @foreach($specialists as $specialist)
        @include('partials.specialist-card', ['specialist' => $specialist])
      @endforeach
    </div>

    @if(empty($specialists))
      <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-slate-100">
        <p class="text-slate-500 text-lg font-medium">No specialists found at the moment.</p>
      </div>
    @endif

    <div class="mt-20 bg-secondary rounded-3xl p-8 md:p-12 overflow-hidden relative shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-xl">
                <h2 class="text-3xl font-bold text-white mb-4">Can't find what you're looking for?</h2>
                <p class="text-white/70 text-lg">
                    Browse our full directory of qualified doctors across all specialities.
                </p>
            </div>
            <a href="{{ home_url('/doctors') }}" class="bg-white text-secondary hover:bg-primary hover:text-white font-bold px-8 py-4 rounded-xl transition-all shadow-lg whitespace-nowrap">
                View All Doctors
            </a>
        </div>
        
        {{-- Decorative circles --}}
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
    </div>

  </div>
</div>
@endsection
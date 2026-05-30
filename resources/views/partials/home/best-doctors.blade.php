<section class="py-12 lg:py-30 bg-slate-50 overflow-hidden">

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    <!-- HEADER -->
    <div class="mx-auto mb-14 max-w-2xl text-center">

      <h5 class="mb-6 text-4xl font-bold leading-tight text-slate-900 lg:text-5xl">
        Best Doctors
      </h5>

    </div>

    <!-- CARDS -->
    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">

      @foreach($doctors as $doctor)
      @include('partials.doctor-card', ['doctor' => $doctor])
      @endforeach

    </div>

  </div>

</section>
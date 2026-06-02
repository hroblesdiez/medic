<section class="section-container bg-slate-50">

  <div class="content-container">

    <!-- HEADER -->
    <div class="section-header-center">

      <h2 class="section-title">
        Best Doctors
      </h2>

    </div>

    <!-- CARDS -->
    <div class="grid-4-cols">

      @foreach($doctors as $doctor)
        @include('partials.doctor-card', ['doctor' => $doctor])
      @endforeach

    </div>

  </div>

</section>

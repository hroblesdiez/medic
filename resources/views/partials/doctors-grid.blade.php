@if(!empty($doctors))
@foreach($doctors as $doctor)
@include('components.doctor-card', ['doctor' => $doctor])
@endforeach
@else
<div class="col-span-full">
  @include('partials.empty-state')
</div>
@endif
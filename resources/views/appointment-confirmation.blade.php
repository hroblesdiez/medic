<div x-data="{
    show: false,
    details: {}
}"
  @fluentform_submission_success.window="
    if ($event.detail.form.id == 3) {
        details = $event.detail.response.appointment_summary;
        show = true;
    }
"
  x-show="show"
  x-cloak
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0 scale-95"
  x-transition:enter-end="opacity-100 scale-100"
  class="max-w-md mx-auto mt-8 p-6 bg-white border border-gray-200 rounded-2xl shadow-xl">
  <div class="flex items-center justify-center w-12 h-12 mx-auto bg-green-100 rounded-full">
    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
  </div>

  <div class="mt-4 text-center">
    <h3 class="text-xl font-bold text-gray-900">¡Cita Confirmada!</h3>
    <p class="mt-2 text-sm text-gray-500">Hola <span x-text="details.name" class="font-medium text-gray-900"></span>, aquí tienes los detalles:</p>
  </div>

  <div class="mt-6 space-y-4 border-t border-gray-100 pt-6">
    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Doctor:</span>
      <span x-text="details.doctor" class="font-semibold text-gray-900"></span>
    </div>
    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Fecha:</span>
      <span x-text="details.date" class="font-semibold text-gray-900"></span>
    </div>
    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Hora:</span>
      <span x-text="details.time" class="font-semibold text-gray-900"></span>
    </div>
  </div>
</div>
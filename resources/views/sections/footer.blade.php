<footer class="bg-[#F6FAFF] border-t border-slate-200 pt-16">

  <div class="container mx-auto px-6">

    {{-- GRID SUPERIOR --}}
    <div class="grid grid-cols-2 md:grid-cols-[15%_15%_15%_15%_30%] lg:justify-center gap-10 lg:gap-0">

      <div>
        <h4 class="font-semibold mb-4!">Company</h4>
        {!! $companyMenu !!}
      </div>

      <div>
        <h4 class="font-semibold mb-4!">Treatments</h4>
        {!! $treatmentsMenu !!}
      </div>

      <div>
        <h4 class="font-semibold mb-4!">Specialities</h4>
        {!! $specialitiesMenu !!}
      </div>

      <div>
        <h4 class="font-semibold mb-4!">Utilities</h4>
        {!! $utilitiesMenu !!}
      </div>

      {{-- NEWSLETTER --}}
      <div class="col-span-2 lg:col-span-1">
        <h4 class="font-semibold mb-4">Newsletter</h4>

        <p class="text-sm text-gray-600 mb-3">
          Subscribe and stay updated
        </p>

        <form class="flex items-center gap-2">
          <input
            type="email"
            placeholder="Enter email address"
            class="w-full px-3 py-2 border rounded-lg text-sm" />

          <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
            Send
          </button>
        </form>

        {{-- SOCIAL --}}
        <div class="mt-6">
          <h5 class="text-sm font-semibold mb-3">Connect With Us</h5>

          <div class="flex gap-3 text-gray-500">
            <a href="#"> <img
                src="{{ Vite::asset('resources/images/social/facebook.svg') }}"
                alt="Facebook"
                class="max-w-8 max-h-8"></a>
            <a href="#"><img
                src="{{ Vite::asset('resources/images/social/twitter.svg') }}"
                alt="X"
                class="max-w-8 max-h-8"></a>
          </div>
        </div>

      </div>

    </div>

    {{-- BOTTOM BAR --}}
    <div class="border-t mt-12 pt-6 flex flex-col md:flex-row justify-between text-sm text-gray-500">

      <p>Copyright &copy; All rights reserved</p>

      <div class="flex gap-4">
        <a href="#">Legal Notice</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Refund Policy</a>
      </div>

    </div>

  </div>

</footer>
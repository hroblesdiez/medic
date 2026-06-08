<form @submit.prevent="submitForm" class="doctor-appointment-form">
  <div class="doctor-form-group">
    <label for="name" class="doctor-form-label">Full Name</label>
    <input type="text" id="name" x-model="formData.name" required class="doctor-form-input" placeholder="Your Name">
  </div>

  <div class="doctor-form-group">
    <label for="email" class="doctor-form-label">Email Address</label>
    <input type="email" id="email" x-model="formData.email" required class="doctor-form-input" placeholder="your@email.com">
  </div>

  <div class="doctor-form-group">
    <label for="date" class="doctor-form-label">Preferred Date</label>
    <input type="date" id="date" x-model="formData.date" :min="minDate" required class="doctor-form-input">
  </div>

  {{-- Slots Container --}}
  <div class="mt-6" x-show="formData.date">
    <label class="doctor-form-label mb-2 block">Available Time Slots</label>
    
    <div x-show="loadingSlots" class="text-blue-200 text-sm">
      Loading slots...
    </div>

    <div x-show="!loadingSlots && slots.length === 0" class="text-red-300 text-sm">
      No available slots for this date.
    </div>

    <div x-show="!loadingSlots && slots.length > 0" class="grid grid-cols-3 gap-2">
      <template x-for="slot in slots" :key="slot">
        <button 
          type="button" 
          @click="selectSlot(slot)"
          :disabled="isSlotPast(slot)"
          :class="{
            'bg-white text-blue-600': selectedSlot === slot,
            'bg-blue-700 text-white hover:bg-blue-500': selectedSlot !== slot && !isSlotPast(slot),
            'bg-blue-800/50 text-blue-300 cursor-not-allowed border-blue-500/30': isSlotPast(slot)
          }"
          class="px-2 py-2 text-sm font-semibold rounded-lg transition-colors border border-blue-400"
          x-text="slot"
        ></button>
      </template>
    </div>
  </div>

  <button type="submit" :disabled="loading || (formData.date && !selectedSlot)" class="doctor-form-submit mt-8">
    <span x-show="!loading">Book Now</span>
    <span x-show="loading">Processing...</span>
  </button>
</form>

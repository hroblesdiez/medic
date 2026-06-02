export default function appointmentForm() {
  return {
    doctorId: null,
    slots: [],
    loadingSlots: false,

    // STATE
    selectedSlot: null,
    email: null,
    date: null,
    name: null,

    /**
     * INIT
     */
    async init() {
      const params = new URLSearchParams(window.location.search);
      this.doctorId = params.get('doctor');

      if (!this.doctorId) {
        console.warn('No doctor selected');
        return;
      }

      // Inject doctor_id into FluentForms hidden field
      const idField = document.querySelector('input[name="doctor_id"]');
      if (idField) idField.value = this.doctorId;

      // Bind listeners
      this.bindEmailListener();
      this.bindDateSelector();
      this.bindFormSubmit();

      // Load availability
      await this.loadAvailability();
    },

    /**
     * LOAD SLOTS
     */
    async loadAvailability() {
      const container = document.querySelector('#slots-container');

      if (!container) return;

      this.loadingSlots = true;

      try {
        const response = await fetch(
          `/wp-json/medic/v1/availability?doctor=${this.doctorId}`,
        );

        const data = await response.json();
        this.slots = data.slots || [];

        container.innerHTML = '';

        if (!this.slots.length) {
          container.innerHTML = `<p>No available slots</p>`;
          return;
        }

        this.slots.forEach((slot) => {
          const btn = document.createElement('button');

          btn.type = 'button';
          btn.innerText = slot;

          btn.className =
            'px-3 py-2 border rounded hover:bg-blue-600 hover:text-white';

          btn.addEventListener('click', () => {
            this.selectedSlot = slot;

            // UI reset
            document
              .querySelectorAll('#slots-container button')
              .forEach((b) => b.classList.remove('bg-blue-600', 'text-white'));

            btn.classList.add('bg-blue-600', 'text-white');
          });

          container.appendChild(btn);
        });
      } catch (err) {
        console.error(err);
        container.innerHTML = `<p>Error loading slots</p>`;
      } finally {
        this.loadingSlots = false;
      }
    },

    /**
     * EMAIL LISTENER
     */
    bindEmailListener() {
      document.addEventListener('input', (e) => {
        if (e.target && e.target.name === 'email') {
          this.email = e.target.value;
        }
      });
    },

    /**
     * DATE LISTENER
     */
    bindDateSelector() {
      document.addEventListener('change', (e) => {
        if (e.target && e.target.name === 'datetime') {
          this.date = e.target.value;
        }
      });
    },

    /**
     * SYNC ALL FIELDS
     */
    syncFields() {
      this.email = document.querySelector('[name="email"]')?.value ?? null;

      const first =
        document.querySelector('[name="names[first_name]"]')?.value ?? '';

      const last =
        document.querySelector('[name="names[last_name]"]')?.value ?? '';

      this.name = `${first} ${last}`.trim();

      this.date = document.querySelector('[name="datetime"]')?.value ?? null;

      // IMPORTANT: write slot into hidden field
      const slotField = document.querySelector('[name="slot_time"]');
      if (slotField) {
        slotField.value = this.selectedSlot;
      }
    },

    /**
     * FORM SUBMIT HOOK
     */
    bindFormSubmit() {
      const form = document.querySelector('.fluentform');

      if (!form) return;

      form.addEventListener('submit', (e) => {
        this.syncFields();
      });
    },
  };
}

export default function appointmentForm() {
  return {
    doctorId: null,
    slots: [],
    loadingSlots: false,
    selectedSlot: null,
    email: null,
    date: null,
    name: null,
    submitted: false,
    summary: {
      name: '',
      doctor: '',
      date: '',
      time: '',
    },

    async init() {
      const params = new URLSearchParams(window.location.search);
      this.doctorId = params.get('doctor');

      if (!this.doctorId) {
        console.warn('No doctor selected');
        return;
      }

      const idField = document.querySelector('input[name="doctor_id"]');
      if (idField) idField.value = this.doctorId;

      this.bindEmailListener();
      this.bindDateSelector();
      this.bindFormSubmit();

      window.addEventListener('appointment-success', (e) => {
        console.log('[Alpine] appointment-success fired');
        console.log('[Alpine] e.detail:', e.detail);
        console.log(
          '[Alpine] e.detail.appointment_summary:',
          e.detail?.appointment_summary,
        );

        const response = e.detail;

        if (!response?.appointment_summary) {
          console.warn(
            '[Alpine] appointment_summary missing — submitted will NOT be set',
          );
          return;
        }

        this.summary = response.appointment_summary;
        this.submitted = true;

        console.log('[Alpine] submitted set to true, summary:', this.summary);

        this.$nextTick(() => {
          window.scrollTo({ top: 0, behavior: 'smooth' });
        });
      });

      await this.loadAvailability();
    },

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

    bindEmailListener() {
      document.addEventListener('input', (e) => {
        if (e.target?.name === 'email') {
          this.email = e.target.value;
        }
      });
    },

    bindDateSelector() {
      document.addEventListener('change', (e) => {
        if (e.target?.name === 'datetime') {
          this.date = e.target.value;
        }
      });
    },

    syncFields() {
      this.email = document.querySelector('[name="email"]')?.value ?? null;

      const first =
        document.querySelector('[name="names[first_name]"]')?.value ?? '';
      const last =
        document.querySelector('[name="names[last_name]"]')?.value ?? '';

      this.name = `${first} ${last}`.trim();
      this.date = document.querySelector('[name="datetime"]')?.value ?? null;

      const slotField = document.querySelector('[name="slot_time"]');
      if (slotField) {
        slotField.value = this.selectedSlot;
      }
    },

    bindFormSubmit() {
      const form = document.querySelector('.fluentform');

      if (!form) return;

      form.addEventListener('submit', () => {
        this.syncFields();
      });
    },
  };
}

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
    submitted: false,
    summary: {
      name: '',
      doctor: '',
      date: '',
      time: '',
    },

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

      const idField = document.querySelector('input[name="doctor_id"]');
      if (idField) idField.value = this.doctorId;

      this.bindEmailListener();
      this.bindDateSelector();
      this.bindFormSubmit();
      this.bindFlatpickrMinDate();

      window.addEventListener('appointment-success', (e) => {
        const response = e.detail;

        if (response.appointment_summary) {
          this.submitted = true;
          this.summary = response.appointment_summary;
          this.$nextTick(() => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
          });
        }
      });

      await this.loadAvailability();
    },

    /**
     * FLATPICKR MIN DATE / TIME
     */
    bindFlatpickrMinDate() {
      const MAX_ATTEMPTS = 40;
      const INTERVAL_MS = 150;
      let attempts = 0;

      const apply = (fp) => {
        const now = new Date();

        fp.set('minDate', now);

        fp.config.onChange.push((selectedDates) => {
          if (!selectedDates.length) return;

          const selected = selectedDates[0];
          const isToday =
            selected.getFullYear() === now.getFullYear() &&
            selected.getMonth() === now.getMonth() &&
            selected.getDate() === now.getDate();

          if (isToday) {
            fp.set(
              'minTime',
              `${now.getHours()}:${String(now.getMinutes()).padStart(2, '0')}`,
            );
          } else {
            fp.set('minTime', '00:00');
          }
        });
      };

      const poll = setInterval(() => {
        attempts++;
        const input = document.querySelector('input[name="datetime"]');

        if (input && input._flatpickr) {
          clearInterval(poll);
          apply(input._flatpickr);
          return;
        }

        if (attempts >= MAX_ATTEMPTS) {
          clearInterval(poll);
          console.warn('Flatpickr instance not found on datetime field.');
        }
      }, INTERVAL_MS);
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

        this.renderSlots();
      } catch (err) {
        console.error(err);
        const container = document.querySelector('#slots-container');
        if (container) container.innerHTML = `<p>Error loading slots</p>`;
      } finally {
        this.loadingSlots = false;
      }
    },

    /**
     * RENDER SLOTS
     *
     * Filters out past slots when the selected date is today.
     * Slot format from the API is "HH:MM" (24h).
     */
    renderSlots() {
      const container = document.querySelector('#slots-container');

      if (!container) return;

      container.innerHTML = '';
      this.selectedSlot = null;

      const now = new Date();
      const nowMinutes = now.getHours() * 60 + now.getMinutes();

      const isToday = (() => {
        if (!this.date) return true;

        // this.date comes from FluentForms as "d/m/Y H:i" or "d/m/Y"
        const parts = this.date.split(' ')[0].split('/');
        if (parts.length < 3) return true;

        const [day, month, year] = parts.map(Number);
        const selected = new Date(year, month - 1, day);

        return (
          selected.getFullYear() === now.getFullYear() &&
          selected.getMonth() === now.getMonth() &&
          selected.getDate() === now.getDate()
        );
      })();

      const visible = isToday
        ? this.slots.filter((slot) => {
            const [h, m] = slot.split(':').map(Number);
            return h * 60 + m > nowMinutes;
          })
        : this.slots;

      if (!visible.length) {
        container.innerHTML = `<p>No available slots</p>`;
        return;
      }

      visible.forEach((slot) => {
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
     * Re-renders slots every time the date changes so the filter stays current.
     */
    bindDateSelector() {
      document.addEventListener('change', (e) => {
        if (e.target && e.target.name === 'datetime') {
          this.date = e.target.value;
          this.renderSlots();
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

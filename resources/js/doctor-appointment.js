export default (doctorId, doctorName) => ({
  loading: false,
  submitted: false,
  error: false,
  loadingSlots: false,
  slots: [],
  selectedSlot: null,
  minDate: new Date().toISOString().split('T')[0],
  summary: {
    name: '',
    doctor: doctorName,
    date: '',
    time: '',
  },
  formData: {
    doctor_id: doctorId,
    name: '',
    email: '',
    date: '',
    time: '',
  },

  init() {
    this.$watch('formData.date', (value) => {
      if (value) {
        this.loadSlots();
      } else {
        this.slots = [];
        this.selectedSlot = null;
        this.formData.time = '';
      }
    });
  },

  async loadSlots() {
    this.loadingSlots = true;
    this.slots = [];
    this.selectedSlot = null;
    this.formData.time = '';

    try {
      const response = await fetch(`/wp-json/medic/v1/availability?doctor=${this.formData.doctor_id}&date=${this.formData.date}`);
      if (!response.ok) throw new Error('Failed to fetch slots');
      
      const data = await response.json();
      this.slots = data.slots || [];
    } catch (err) {
      console.error('Error loading slots:', err);
    } finally {
      this.loadingSlots = false;
    }
  },

  isSlotPast(slot) {
    if (!this.formData.date) return false;
    
    const now = new Date();
    const [year, month, day] = this.formData.date.split('-').map(Number);
    const selected = new Date(year, month - 1, day);

    const isToday = (
      selected.getFullYear() === now.getFullYear() &&
      selected.getMonth() === now.getMonth() &&
      selected.getDate() === now.getDate()
    );

    if (!isToday) return false;

    const [hours, minutes] = slot.split(':').map(Number);
    const slotTime = new Date(year, month - 1, day, hours, minutes);

    return slotTime < now;
  },

  selectSlot(slot) {
    if (this.isSlotPast(slot)) return;
    this.selectedSlot = slot;
    this.formData.time = slot;
  },

  async submitForm() {
    if (!this.formData.time) {
      alert('Please select a time slot');
      return;
    }

    this.loading = true;
    this.error = false;
    this.submitted = false;

    try {
      const nonce = window.medicConfig?.nonce || '';
      
      const response = await fetch('/wp-json/medic/v1/appointments', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': nonce,
        },
        body: JSON.stringify(this.formData),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Network response was not ok');
      }

      // Populate summary
      this.summary.name = this.formData.name;
      this.summary.date = this.formData.date;
      this.summary.time = this.formData.time;

      this.submitted = true;

      // Reset form
      this.formData = {
        doctor_id: doctorId,
        name: '',
        email: '',
        date: '',
        time: '',
      };
      this.slots = [];
      this.selectedSlot = null;
    } catch (err) {
      console.error('Appointment Error:', err);
      this.error = true;
    } finally {
      this.loading = false;
    }
  },
});

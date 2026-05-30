export default function faqComponent() {
  return {
    active: null,

    toggle(index) {
      this.active = this.active === index ? null : index;
    },

    isActive(index) {
      return this.active === index;
    },
  };
}

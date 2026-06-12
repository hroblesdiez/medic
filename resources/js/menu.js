export default function menu() {
  return {
    open: false,
    activeSubmenu: null,

    toggleMenu() {
      this.open = !this.open;
    },

    closeMenu() {
      this.open = false;
      this.activeSubmenu = null;
    },

    toggleSubmenu(index) {
      if (window.innerWidth >= 1024) return;

      this.activeSubmenu = this.activeSubmenu === index ? null : index;
    },

    isSubmenuOpen(index) {
      return this.activeSubmenu === index;
    },

    handleResize() {
      if (window.innerWidth >= 1024) {
        this.closeMenu();
      }
    },

    init() {
      this.$watch('open', (value) => {
        document.body.classList.toggle('overflow-hidden', value);
      });

      window.addEventListener('resize', () => {
        this.handleResize();
      });

      window.addEventListener('beforeunload', () => {
        document.body.classList.remove('overflow-hidden');
      });
    },
  };
}

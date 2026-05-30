export default function menu() {
  return {
    open: false,
    activeSubmenu: null,

    toggleMenu() {
      this.open = !this.open;

      document.body.classList.toggle('overflow-hidden', this.open);
    },

    closeMenu() {
      this.open = false;
      this.activeSubmenu = null;

      document.body.classList.remove('overflow-hidden');
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
      window.addEventListener('resize', () => {
        this.handleResize();
      });
    },
  };
}

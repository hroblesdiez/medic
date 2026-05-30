export default function testimonials() {
  return {
    currentIndex: 0,
    interval: null,

    init() {
      this.update();
      this.startAutoplay();
    },

    get totalSlides() {
      return document.querySelectorAll('.testimonial-slide').length;
    },

    next() {
      this.currentIndex = (this.currentIndex + 1) % this.totalSlides;

      this.update();
    },

    prev() {
      this.currentIndex =
        (this.currentIndex - 1 + this.totalSlides) % this.totalSlides;

      this.update();
    },

    update() {
      const track = document.querySelector('.testimonials-track');
      if (!track) return;

      track.style.transform = `translateX(-${this.currentIndex * 100}%)`;
    },

    startAutoplay() {
      this.interval = setInterval(() => {
        this.next();
      }, 6000);
    },

    stopAutoplay() {
      clearInterval(this.interval);
    },
  };
}

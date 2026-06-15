import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

import testimonials from './testimonials';
import faqComponent from './faq';
import menu from './menu';
import doctorFilter from './doctor-filter';
import blogLoadMore from './blog-load-more';
import appointmentForm from './appointment-form';
import doctorAppointment from './doctor-appointment';
import initializeCookieBanner from './cookie-banner.js';

window.Alpine = Alpine;

Alpine.plugin(collapse);

Alpine.data('faqComponent', faqComponent);
Alpine.data('testimonials', testimonials);
Alpine.data('menu', menu);
Alpine.data('doctorFilter', doctorFilter);
Alpine.data('blogLoadMore', blogLoadMore);
Alpine.data('appointmentForm', appointmentForm);

document.addEventListener('alpine:initialized', () => {
  try {
    initializeCookieBanner();
  } catch (error) {
    console.error('Error initializing Cookie Banner:', error);
  }
});

document.addEventListener('DOMContentLoaded', () => {
  if (window.jQuery) {
    jQuery(document).on('fluentform_submission_success', function (ev, data) {
      const result = data?.response?.data?.result ?? {};

      const event = new CustomEvent('appointment-success', {
        detail: result,
        bubbles: true,
      });

      window.dispatchEvent(event);
    });
  }
});

Alpine.start();

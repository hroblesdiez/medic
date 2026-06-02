import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

import testimonials from './testimonials';
import faqComponent from './faq';
import menu from './menu';
import doctorFilter from './doctor-filter';
import blogLoadMore from './blog-load-more';
import appointmentForm from './appointment-form';

window.Alpine = Alpine;

Alpine.plugin(collapse);

Alpine.data('faqComponent', faqComponent);
Alpine.data('testimonials', testimonials);
Alpine.data('menu', menu);
Alpine.data('doctorFilter', doctorFilter);
Alpine.data('blogLoadMore', blogLoadMore);
Alpine.data('appointmentForm', appointmentForm);

Alpine.start();

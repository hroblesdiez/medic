# Medic WordPress Theme

Professional WordPress theme for medical clinics, built with Sage 11 and a component-first architecture.

# Tech Stack

- WordPress
- Sage 11 (Roots ecosystem)
- Acorn (Laravel components for WordPress)
- Blade (Templating engine)
- Tailwind CSS v4 (Styling framework)
- Alpine.js (Lightweight JavaScript)
- Vite (Build tool and development server)
- Carbon Fields (Custom fields and options)
- Fluent Forms (Form management)
- Google Analytics (Performance tracking)
- GDPR Consent Management (Custom implementation)

# Architecture

The project follows a modern, service-oriented architecture within the Sage 11 ecosystem:

- **App Layer**: Business logic is centralized in `app/Services` and `app/Api`.
- **View Layer**: Blade templates in `resources/views` are presentation-only, receiving prepared data from **View Composers** located in `app/View/Composers`.
- **Styles**: Organized as semantic components in `resources/css`, leveraging Tailwind v4 utilities and CSS variables for a robust design system.
- **Interactivity**: Powered by modular Alpine.js components in `resources/js`, providing high performance without the overhead of larger frameworks.

# Features

- **Doctor Directory**: Advanced filtering and search functionality using a custom REST API and progressive enhancement with Alpine.js.
- **Appointment Booking**: Integrated booking flow with real-time feedback and data validation.
- **Dynamic Content**: Managed via Carbon Fields for Doctors, Specialities, Testimonials, and FAQs.
- **Responsive Layout**: Fully optimized for all screen sizes, starting from 320px up to ultra-wide displays.
- **Privacy First**: Built-in GDPR-compliant cookie consent manager with granular category controls.

# Performance Considerations

- **Vite Integration**: Provides lightning-fast HMR and optimized production bundles.
- **Tailwind v4 JIT**: Ensures only required CSS is delivered to the client, minimizing the critical CSS footprint.
- **Optimized Assets**: Modular JavaScript and minimal dependencies ensure fast initial page loads and high Lighthouse scores.
- **Lazy Loading**: Progressive loading of assets and images to optimize Core Web Vitals (LCP, CLS).

# Accessibility

The theme targets WCAG 2.2 AA compliance:

- Semantic HTML structure.
- Visible focus states for all interactive elements.
- ARIA labels and roles for dynamic components.
- Logical heading hierarchy throughout all templates.
- Keyboard-accessible navigation and forms.

# Security

- **Output Escaping**: All dynamic data is strictly escaped using WordPress security functions (`esc_html`, `esc_url`, `esc_attr`).
- **Data Sanitization**: Input data is sanitized and validated at the service layer.
- **REST Protection**: Custom API endpoints implement proper permission callbacks and nonce verification where applicable.

# Development

### Requirements

- PHP 8.1+
- Node.js 18+
- Composer
- WP-CLI

### Installation

1. Clone the repository into your WordPress themes directory.
2. Run `composer install` to install PHP dependencies.
3. Run `npm install` to install JavaScript dependencies.

# Build Commands

- `npm run dev`: Start the Vite development server with HMR.
- `npm run build`: Generate production-ready assets.
- `composer test`: Run PHPUnit tests (if applicable).

# Deployment Notes

- Ensure the `public/` directory is writable by the web server for asset generation.
- The theme expects Acorn to be installed and active (either as a plugin or via composer).
- Production assets must be generated via `npm run build` before deployment.

# Future Improvements

- Implementation of server-side caching for complex API queries.
- Expanded automated testing coverage for Alpine.js components.
- Further optimization of high-resolution image assets.

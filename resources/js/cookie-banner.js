export default function initializeCookieBanner() {
  const STORAGE_KEY = 'medic_cookie_consent';
  const COOKIE_DURATION = 365 * 24 * 60 * 60 * 1000;

  const defaultConsent = {
    analytics: false,
    timestamp: Date.now(),
  };

  function getConsent() {
    const stored = localStorage.getItem(STORAGE_KEY);
    return stored ? JSON.parse(stored) : null;
  }

  function setConsent(consent) {
    const data = {
      ...consent,
      timestamp: Date.now(),
    };
    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
  }

  function saveCookie(name, value, days = 365) {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
  }

  function loadGoogleAnalytics() {
    if (window.gtag) return;

    const consent = getConsent();
    if (!consent?.analytics) return;

    const gaMeasurementId = document.documentElement.dataset.gaId;
    if (!gaMeasurementId) return;

    window.dataLayer = window.dataLayer || [];
    function gtag() {
      window.dataLayer.push(arguments);
    }
    window.gtag = gtag;

    gtag('consent', 'default', {
      analytics_storage: 'granted',
    });

    const script = document.createElement('script');
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${gaMeasurementId}`;
    document.head.appendChild(script);

    gtag('config', gaMeasurementId, {
      anonymize_ip: true,
    });
  }

  function createBanner() {
    const banner = document.createElement('div');
    banner.className = 'cookie-banner';
    banner.id = 'cookie-banner';

    banner.innerHTML = `
      <div class="cookie-banner__container">
        <div class="cookie-banner__content">
          <div class="cookie-banner__text">
            <p class="cookie-banner__title">Cookie Settings</p>
            <p class="cookie-banner__description">
              We use cookies to enhance your experience and analyze site usage.
              <a href="/privacy-policy/" class="cookie-banner__link">Learn more</a>
            </p>
          </div>
          <div class="cookie-banner__actions">
            <button class="cookie-banner__btn cookie-banner__btn--reject" id="cookie-reject">
              Reject All
            </button>
            <button class="cookie-banner__btn cookie-banner__btn--settings" id="cookie-settings">
              Settings
            </button>
            <button class="cookie-banner__btn cookie-banner__btn--accept" id="cookie-accept">
              Accept All
            </button>
          </div>
        </div>
      </div>
    `;

    document.body.appendChild(banner);

    document.getElementById('cookie-accept').addEventListener('click', () => {
      const consent = { analytics: true };
      setConsent(consent);
      saveCookie('medic_analytics_consent', 'true');
      banner.remove();
      loadGoogleAnalytics();
    });

    document.getElementById('cookie-reject').addEventListener('click', () => {
      const consent = { analytics: false };
      setConsent(consent);
      saveCookie('medic_analytics_consent', 'false');
      banner.remove();
    });

    document.getElementById('cookie-settings').addEventListener('click', () => {
      showSettingsModal();
    });
  }

  function showSettingsModal() {
    const consent = getConsent() || defaultConsent;
    const overlay = document.createElement('div');
    overlay.className = 'cookie-banner__modal';
    overlay.id = 'cookie-modal';

    overlay.innerHTML = `
      <div class="cookie-banner__modal-content">
        <div class="cookie-banner__modal-header">
          <h2 class="cookie-banner__modal-title">Cookie Preferences</h2>
          <button class="cookie-banner__modal-close" id="modal-close">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <div class="cookie-banner__modal-section">
          <h3 class="cookie-banner__modal-section-title">Essential Cookies</h3>
          <p class="cookie-banner__modal-section-text">
            Required for the website to function. Always enabled.
          </p>
          <div class="cookie-banner__toggle">
            <label class="cookie-banner__toggle-label">Session & Security</label>
            <div class="cookie-banner__toggle-switch" style="opacity: 0.5;">
              <div class="cookie-banner__toggle-switch-knob" style="opacity: 0.5;"></div>
            </div>
          </div>
        </div>

        <div class="cookie-banner__modal-section">
          <h3 class="cookie-banner__modal-section-title">Analytics</h3>
          <p class="cookie-banner__modal-section-text">
            Help us understand how you use our site to improve your experience. We use Google Analytics with IP anonymization.
          </p>
          <div class="cookie-banner__toggle">
            <label class="cookie-banner__toggle-label">Google Analytics</label>
            <div class="cookie-banner__toggle-switch ${consent.analytics ? 'active' : ''}" id="analytics-toggle">
              <div class="cookie-banner__toggle-switch-knob"></div>
            </div>
          </div>
        </div>

        <div class="cookie-banner__modal-actions">
          <button class="cookie-banner__modal-btn cookie-banner__modal-btn--reject" id="modal-reject">
            Reject All
          </button>
          <button class="cookie-banner__modal-btn cookie-banner__modal-btn--accept" id="modal-accept">
            Save Preferences
          </button>
        </div>
      </div>
    `;

    document.body.appendChild(overlay);

    const toggle = document.getElementById('analytics-toggle');
    toggle.addEventListener('click', () => {
      toggle.classList.toggle('active');
    });

    document
      .getElementById('modal-close')
      .addEventListener('click', () => overlay.remove());
    document.getElementById('modal-reject').addEventListener('click', () => {
      setConsent({ analytics: false });
      saveCookie('medic_analytics_consent', 'false');
      overlay.remove();
    });
    document.getElementById('modal-accept').addEventListener('click', () => {
      const analyticsEnabled = document
        .getElementById('analytics-toggle')
        .classList.contains('active');
      const consent = { analytics: analyticsEnabled };
      setConsent(consent);
      saveCookie(
        'medic_analytics_consent',
        analyticsEnabled ? 'true' : 'false',
      );
      if (analyticsEnabled) {
        loadGoogleAnalytics();
      }
      overlay.remove();
    });

    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) overlay.remove();
    });
  }

  function init() {
    const consent = getConsent();

    if (!consent) {
      createBanner();
    } else if (consent.analytics) {
      loadGoogleAnalytics();
    }

    window.medicCookieConsent = {
      getConsent,
      setConsent,
      showSettings: showSettingsModal,
    };
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
}

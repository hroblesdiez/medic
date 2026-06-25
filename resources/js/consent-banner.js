const STORAGE_KEY = 'medic_cookie_consent';

const defaultConsent = {
  analytics: false,
  timestamp: Date.now(),
};

function getConsent() {
  const stored = localStorage.getItem(STORAGE_KEY);
  return stored ? JSON.parse(stored) : null;
}

function setConsent(consent) {
  localStorage.setItem(
    STORAGE_KEY,
    JSON.stringify({
      ...consent,
      timestamp: Date.now(),
    }),
  );
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
  window.gtag = function () {
    window.dataLayer.push(arguments);
  };

  window.gtag('consent', 'default', { analytics_storage: 'granted' });

  const script = document.createElement('script');
  script.async = true;
  script.src = `https://www.googletagmanager.com/gtag/js?id=${gaMeasurementId}`;
  document.head.appendChild(script);

  window.gtag('config', gaMeasurementId, { anonymize_ip: true });
}

function createBanner() {
  const banner = document.createElement('div');
  banner.className = 'consent-banner';
  banner.id = 'consent-banner';

  banner.innerHTML = `
    <div class="consent-banner__container">
      <div class="consent-banner__content">
        <div class="consent-banner__text">
          <p class="consent-banner__title">Cookie Settings</p>
          <p class="consent-banner__description">
            We use cookies to enhance your experience and analyze site usage.
            <a href="/privacy-policy/" class="consent-banner__link">Learn more</a>
          </p>
        </div>
        <div class="consent-banner__actions">
          <button class="consent-banner__btn consent-banner__btn--reject" id="consent-reject">Reject All</button>
          <button class="consent-banner__btn consent-banner__btn--settings" id="consent-settings">Settings</button>
          <button class="consent-banner__btn consent-banner__btn--accept" id="consent-accept">Accept All</button>
        </div>
      </div>
    </div>
  `;

  document.body.appendChild(banner);

  banner.querySelector('#consent-accept').addEventListener('click', () => {
    setConsent({ analytics: true });
    saveCookie('medic_analytics_consent', 'true');
    banner.remove();
    loadGoogleAnalytics();
  });

  banner.querySelector('#consent-reject').addEventListener('click', () => {
    setConsent({ analytics: false });
    saveCookie('medic_analytics_consent', 'false');
    banner.remove();
  });

  banner.querySelector('#consent-settings').addEventListener('click', () => {
    showSettingsModal();
  });
}

function showSettingsModal() {
  const consent = getConsent() || defaultConsent;
  const overlay = document.createElement('div');
  overlay.className = 'consent-banner__modal';
  overlay.id = 'consent-modal';

  overlay.innerHTML = `
    <div class="consent-banner__modal-content">
      <div class="consent-banner__modal-header">
        <h2 class="consent-banner__modal-title">Cookie Preferences</h2>
        <button class="consent-banner__modal-close" id="modal-close">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <div class="consent-banner__modal-section">
        <h3 class="consent-banner__modal-section-title">Essential Cookies</h3>
        <p class="consent-banner__modal-section-text">Required for the website to function. Always enabled.</p>
        <div class="consent-banner__toggle">
          <label class="consent-banner__toggle-label">Session & Security</label>
          <div class="consent-banner__toggle-switch" style="opacity:0.5;">
            <div class="consent-banner__toggle-switch-knob" style="opacity:0.5;"></div>
          </div>
        </div>
      </div>
      <div class="consent-banner__modal-section">
        <h3 class="consent-banner__modal-section-title">Analytics</h3>
        <p class="consent-banner__modal-section-text">Help us understand how you use our site. We use Google Analytics with IP anonymization.</p>
        <div class="consent-banner__toggle">
          <label class="consent-banner__toggle-label">Google Analytics</label>
          <div class="consent-banner__toggle-switch ${consent.analytics ? 'active' : ''}" id="analytics-toggle">
            <div class="consent-banner__toggle-switch-knob"></div>
          </div>
        </div>
      </div>
      <div class="consent-banner__modal-actions">
        <button class="consent-banner__modal-btn consent-banner__modal-btn--reject" id="modal-reject">Reject All</button>
        <button class="consent-banner__modal-btn consent-banner__modal-btn--accept" id="modal-accept">Save Preferences</button>
      </div>
    </div>
  `;

  document.body.appendChild(overlay);

  overlay.querySelector('#analytics-toggle').addEventListener('click', (e) => {
    e.currentTarget.classList.toggle('active');
  });

  overlay
    .querySelector('#modal-close')
    .addEventListener('click', () => overlay.remove());

  overlay.querySelector('#modal-reject').addEventListener('click', () => {
    setConsent({ analytics: false });
    saveCookie('medic_analytics_consent', 'false');
    overlay.remove();
  });

  overlay.querySelector('#modal-accept').addEventListener('click', () => {
    const analyticsEnabled = overlay
      .querySelector('#analytics-toggle')
      .classList.contains('active');
    setConsent({ analytics: analyticsEnabled });
    saveCookie('medic_analytics_consent', analyticsEnabled ? 'true' : 'false');
    if (analyticsEnabled) loadGoogleAnalytics();
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

export default function initializeConsentBanner() {
  init();
}

'use strict';

module.exports = class Htmx {

  constructor($elm, _window = window, doc = document) {
    this.window = _window;
    this.isSingleton = true;

    Htmx.init(doc);
  }

  static init(doc) {
    Htmx.loadDependencies(doc);
    if ('MutationObserver' in window) {
      if (!Htmx.dependenciesAlreadySetup(doc)) {
        let observer = new MutationObserver((mutations, observer) => {
          Htmx.loadDependencies(doc);
          if (Htmx.dependenciesAlreadySetup(doc)) {
            observer.disconnect();
          }
        });
        observer.observe(doc.body, { childList: true, subtree: true });
      }
    }
  }

  static loadDependencies(doc) {
    if (doc.querySelector('[hx-get],[hx-post],[hx-put],[hx-patch],[hx-delete],[hx-trigger],[hx-boost]')) {
      Htmx.load(doc);
    }
  }

  static dependenciesAlreadySetup(doc) {
    return !!doc.querySelector('script[src*="htmx"]');
  }

  // If this fails to load (CDN blocked, offline, etc.) the page still works: every
  // hx-* element already has a real href/action fallback, so this is a pure enhancement.
  static load(doc) {
    if (Htmx.dependenciesAlreadySetup(doc)) {
      return;
    }
    let script = doc.createElement('script');
    script.type = 'text/javascript';
    script.addEventListener('error', () => console.warn('htmx failed to load; falling back to standard navigation'));
    script.src = 'https://cdn.jsdelivr.net/npm/htmx.org@2.0.10/dist/htmx.min.js';
    script.integrity = 'sha384-H5SrcfygHmAuTDZphMHqBJLc3FhssKjG7w/CeCpFReSfwBWDTKpkzPP8c+cLsK+V';
    script.crossOrigin = 'anonymous';
    doc.querySelector('body').appendChild(script);
  }
};

'use strict';

module.exports = class InstitutionEligibilityChecker {

  constructor($elm, _window = window, doc = document) {
    if (!$elm) {
      return;
    }

    this.$elm = $elm;
    this.window = _window;

    this.$form = $elm.querySelector('form');
    this.$input = $elm.querySelector('input[type="search"]');
    this.$results = doc.getElementById('institution-eligibility-checker-results');

    if (!(this.$form && this.$input && this.$results)) {
      return;
    }

    this.requestId = 0;
    this.$input.addEventListener('input', this.handleInput.bind(this));
    this.$form.addEventListener('submit', this.handleSubmit.bind(this));
  }

  handleInput() {
    this.window.clearTimeout(this.debounceTimer);
    this.debounceTimer = this.window.setTimeout(() => this.search(), 300);
  }

  handleSubmit(e) {
    e.preventDefault();
    this.window.clearTimeout(this.debounceTimer);
    this.search();
  }

  search() {
    let requestId = ++this.requestId;

    if (!this.$input.value.trim()) {
      this.$results.innerHTML = '';
      return;
    }

    let url = this.$form.action + '?' + this.$input.name + '=' + encodeURIComponent(this.$input.value);

    this.loadFragment(url).then(
      (html) => {
        if (requestId === this.requestId) {
          this.$results.innerHTML = html;
        }
      },
      () => {
        // If the request itself fails (network error, non-2xx), fall back to a real page load.
        if (requestId === this.requestId) {
          this.window.location.href = url;
        }
      }
    );
  }

  loadFragment(url) {
    return new Promise((resolve, reject) => {
      let xhr = new this.window.XMLHttpRequest();
      xhr.addEventListener('load', () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          resolve(xhr.responseText);
        } else {
          reject();
        }
      });
      xhr.addEventListener('error', reject);
      xhr.open('GET', url);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.send();
    });
  }

};

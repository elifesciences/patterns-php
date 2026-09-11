'use strict';

const uFuzzy = require('@leeoniya/ufuzzy');

const MAX_RESULTS = 20;

module.exports = class InstitutionEligibilityChecker {

  constructor($elm, _window = window, doc = document) {
    if (!$elm) {
      return;
    }

    this.$elm = $elm;
    this.window = _window;
    this.doc = doc;

    this.$form = $elm.querySelector('form');
    this.$input = $elm.querySelector('input[type="search"]');
    this.$country = $elm.querySelector('input[name="country"]');
    this.$results = doc.getElementById('institution-eligibility-checker-results');

    if (!(this.$form && this.$input && this.$results)) {
      return;
    }

    this.institutions = [];
    this.emptyMessage = this.$elm.getAttribute('data-empty-message') || '';

    let institutionsUrl = this.$elm.getAttribute('data-institutions-url');
    if (institutionsUrl) {
      this.loadInstitutions(institutionsUrl);
    }

    this.$input.addEventListener('input', this.handleInput.bind(this));

    this.uf = new uFuzzy({});

    console.log('InstitutionEligibilityChecker loaded.');
  }

  // Fetched once on init, then filtered locally on every keystroke - no
  // network request per keystroke.
  loadInstitutions(url) {
    return new Promise((resolve) => {
      let xhr = new this.window.XMLHttpRequest();
      xhr.addEventListener('load', () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          try {
            resolve(JSON.parse(xhr.responseText));
            return;
          } catch {
            // Malformed payload: treat as no data, handled below.
          }
        }
        resolve([]);
      });
      xhr.addEventListener('error', () => resolve([]));
      xhr.open('GET', url);
      xhr.send();
    }).then((institutions) => {
      this.institutions = institutions;
      this.institutionNames = uFuzzy.latinize(institutions.map(i => i.name));

      if (this.$input.value.trim()) {
        this.search();
      }
    });
  }

  handleInput() {
    this.search();
  }

  search() {
    let query = uFuzzy.latinize(this.$input.value.trim().toLowerCase());

    if (!query) {
      this.$results.innerHTML = '';
      return;
    }

    let [idxs, info, order] = this.uf.search(this.institutionNames, query);

    let matches = [];
    if (idxs != null && idxs.length > 0) {
      // order/info are only computed below uFuzzy's infoThresh (default 1000
      // matches) - past that, fall back to the raw, unranked matches.
      matches = (order != null)
        ? order.map(o => this.institutions[info.idx[o]]).slice(0, MAX_RESULTS)
        : idxs.slice(0, MAX_RESULTS).map(idx => this.institutions[idx]);
    }

    this.render(matches);
  }

  render(matches) {
    this.$results.innerHTML = '';

    if (!matches.length) {
      if (this.emptyMessage) {
        let $empty = this.doc.createElement('p');
        $empty.className = 'institution-search-results__empty';
        $empty.textContent = this.emptyMessage;
        this.$results.appendChild($empty);
      }
      return;
    }

    let $list = this.doc.createElement('ul');
    $list.className = 'institution-search-results__list';

    matches.forEach((institution) => {
      $list.appendChild(this.buildResultItem(institution));
    });

    this.$results.appendChild($list);
  }

  buildResultItem(institution) {
    let $item = this.doc.createElement('li');
    $item.className = 'institution-search-results__item';

    let $link = this.doc.createElement('a');
    $link.className = 'institution-search-results__link';
    $link.href = '/eligibility/check/' + encodeURIComponent(institution.name);
    $link.textContent = `${institution.name} (${institution.city}, ${institution.country})`;

    $item.appendChild($link);

    return $item;
  }
};

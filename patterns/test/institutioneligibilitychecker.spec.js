let expect = chai.expect;

// load in component(s) to be tested
let InstitutionEligibilityChecker = require('../assets/js/components/InstitutionEligibilityChecker');

// The bundled sinon build here has no fake-XHR/fake-server feature, so this is
// a minimal stand-in: it records what it was asked to load and lets the test
// resolve it synchronously via respond().
class FakeXhr {
  constructor() {
    this._listeners = {};
    FakeXhr.instances.push(this);
  }

  open(method, url) {
    this.method = method;
    this.url = url;
  }

  send() {}

  addEventListener(event, handler) {
    this._listeners[event] = handler;
  }

  respond(status, body) {
    this.status = status;
    this.responseText = body;
    this._listeners.load && this._listeners.load();
  }

  error() {
    this._listeners.error && this._listeners.error();
  }
}

describe('An InstitutionEligibilityChecker Component', function () {
  'use strict';

  // Each test constructs a new InstitutionEligibilityChecker against this same
  // fixture markup, which would otherwise leak an 'input' listener per test
  // (never removed) onto the shared $input. Resetting the markup before every
  // test discards those stale listeners along with their DOM nodes.
  let pristineHtml = document.querySelector('[data-behaviour="InstitutionEligibilityChecker"]').innerHTML;

  let $elm;
  let windowMock;
  let requests;

  beforeEach(function () {
    $elm = document.querySelector('[data-behaviour="InstitutionEligibilityChecker"]');
    $elm.innerHTML = pristineHtml;

    FakeXhr.instances = [];
    requests = FakeXhr.instances;

    windowMock = {
      XMLHttpRequest: FakeXhr
    };
  });

  afterEach(function () {
    document.getElementById('institution-eligibility-checker-results').innerHTML = '';
    $elm.querySelector('input[type="search"]').value = '';
    $elm.querySelector('input[name="country"]').value = '';
  });

  it('exists', function () {
    let checker = new InstitutionEligibilityChecker($elm, windowMock);
    expect(checker).to.exist;
  });

  it('fetches the institutions list once, on instantiation', function () {
    new InstitutionEligibilityChecker($elm, windowMock);

    expect(requests.length).to.equal(1);
    expect(requests[0].url).to.equal('/institutions.json');
  });

  describe('once the institutions list has loaded', function () {
    let checker;
    let $input;
    let $results;

    let institutions = [
      { name: 'University of Sheffield', city: 'Sheffield', country: 'United Kingdom' },
      { name: 'Sheffield Hallam University', city: 'Sheffield', country: 'United Kingdom' },
      { name: 'Stanford University', city: 'Stanford', country: 'United States' }
    ];

    beforeEach(async function () {
      checker = new InstitutionEligibilityChecker($elm, windowMock);
      requests[0].respond(200, JSON.stringify(institutions));
      // loadInstitutions() stores the response via a promise callback, which
      // runs as a microtask - wait a tick so it's applied before each test runs.
      await Promise.resolve();

      $input = $elm.querySelector('input[type="search"]');
      $results = document.getElementById('institution-eligibility-checker-results');
    });

    it('does not make another request while typing', function () {
      $input.value = 'sheffield';
      $input.dispatchEvent(new Event('input'));

      expect(requests.length).to.equal(1);
    });

    it('renders the institutions matching the typed query', function () {
      $input.value = 'sheffield';
      $input.dispatchEvent(new Event('input'));

      // Order is uFuzzy's relevance ranking, not insertion order - assert membership, not position.
      let items = $results.querySelectorAll('.institution-search-results__item');
      let names = Array.from(items).map(item => item.textContent);
      expect(items.length).to.equal(2);
      expect(names.some(name => name.includes('University of Sheffield'))).to.be.true;
      expect(names.some(name => name.includes('Sheffield Hallam University'))).to.be.true;
    });

    it('matches case-insensitively', function () {
      $input.value = 'STANFORD';
      $input.dispatchEvent(new Event('input'));

      let items = $results.querySelectorAll('.institution-search-results__item');
      expect(items.length).to.equal(1);
    });

    it('shows the empty message when nothing matches', function () {
      $input.value = 'an institution that does not exist';
      $input.dispatchEvent(new Event('input'));

      let $empty = $results.querySelector('.institution-search-results__empty');
      expect($empty).to.exist;
      expect($empty.textContent).to.equal('No matching institution found.');
    });

    it('clears the results once the input is emptied', function () {
      $input.value = 'sheffield';
      $input.dispatchEvent(new Event('input'));

      $input.value = '';
      $input.dispatchEvent(new Event('input'));

      expect($results.innerHTML).to.equal('');
    });

    it('links each result straight to its own eligibility check page', function () {
      $input.value = 'stanford';
      $input.dispatchEvent(new Event('input'));

      let $link = $results.querySelector('.institution-search-results__link');
      expect($link.getAttribute('href')).to.equal('/eligibility/check?institution=Stanford%20University');
    });

  });

  describe('when a query matches more institutions than uFuzzy will rank (infoThresh)', function () {
    it('still renders unranked matches instead of crashing', async function () {
      // uFuzzy only computes info/order (used for ranking) below its default
      // infoThresh of 1000 raw matches - past that they come back null and
      // search() must fall back to the raw, unranked idxs.
      let manyInstitutions = Array.from({ length: 1500 }, (_, i) => ({
        name: `Test University ${i}`,
        city: 'Testville',
        country: 'Testland'
      }));

      let checker = new InstitutionEligibilityChecker($elm, windowMock);
      requests[0].respond(200, JSON.stringify(manyInstitutions));
      await Promise.resolve();

      let $input = $elm.querySelector('input[type="search"]');
      let $results = document.getElementById('institution-eligibility-checker-results');

      $input.value = 'test university';
      $input.dispatchEvent(new Event('input'));

      let items = $results.querySelectorAll('.institution-search-results__item');
      expect(items.length).to.equal(20);
    });
  });

});

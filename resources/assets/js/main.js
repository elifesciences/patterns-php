(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var utils = require('../libs/elife-utils')();

module.exports = function () {

  // Passing window and document separately allows for independent mocking of window in order
  // to test feature support fallbacks etc.

  function ArticleDownloadLinksList($elm) {
    var _window = arguments.length <= 1 || arguments[1] === undefined ? window : arguments[1];

    var doc = arguments.length <= 2 || arguments[2] === undefined ? document : arguments[2];

    _classCallCheck(this, ArticleDownloadLinksList);

    if (!$elm) {
      return;
    }

    this.window = _window;
    this.doc = doc;
    this.$elm = $elm;

    // One statement per class name because IE doesn't support multiple strings, comma separated.
    this.$elm.classList.add('article-download-links-list--js');
    this.$elm.classList.add('visuallyhidden');
    this.moveList();
    this.$toggler = this.doc.querySelector('.content-header__download_link');
    this.$toggler.addEventListener('click', this.toggle.bind(this));
  }

  /**
   * Moves the download links list to be by the icon this.$toggler
   */


  _createClass(ArticleDownloadLinksList, [{
    key: 'moveList',
    value: function moveList() {
      var $newParent = this.doc.querySelector('.content-header_top');
      var $followingSibling = $newParent.querySelector('.content-header__download_link').nextElementSibling;
      $newParent.insertBefore(this.$elm, $followingSibling);
    }

    /**
     * Toggles the download links list display.
     *
     * @param e The event triggering the display toggle
     */

  }, {
    key: 'toggle',
    value: function toggle(e) {
      e.preventDefault();
      e.stopPropagation();
      if (this.isOpen()) {
        this.close();
      } else {
        this.open();
      }
    }

    /**
     * Returns whether links list is currently viewable.
     *
     * @returns {boolean} Whether links list is currently viewable
     */

  }, {
    key: 'isOpen',
    value: function isOpen() {
      return !this.$elm.classList.contains('visuallyhidden');
    }

    /**
     * Make viewable.
     */

  }, {
    key: 'open',
    value: function open() {
      this.$elm.classList.remove('visuallyhidden');
      this.window.addEventListener('click', this.checkForClose.bind(this));
    }

    /**
     * Checks whether a click occurred outside this, and close this if it did.
     *
     * @param e The click event to evaluate the target of
     */

  }, {
    key: 'checkForClose',
    value: function checkForClose(e) {
      if (!utils.areElementsNested(this.$elm, e.target)) {
        this.close();
      }
    }

    /**
     * Make unviewable.
     */

  }, {
    key: 'close',
    value: function close() {
      this.$elm.classList.add('visuallyhidden');
      this.window.removeEventListener('click', this.checkForClose.bind(this));
    }
  }]);

  return ArticleDownloadLinksList;
}();

},{"../libs/elife-utils":9}],2:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var utils = require('../libs/elife-utils')();
module.exports = function () {

  // Passing window and document separately allows for independent mocking of window in order
  // to test feature support fallbacks etc.

  function AudioPlayer($elm) {
    var _this = this;

    var _window = arguments.length <= 1 || arguments[1] === undefined ? window : arguments[1];

    var doc = arguments.length <= 2 || arguments[2] === undefined ? document : arguments[2];

    _classCallCheck(this, AudioPlayer);

    if (!$elm) {
      console.warn('No element provided');
      return;
    }

    if (!_window.HTMLAudioElement) {
      console.warn('Audio element not supported');
      return;
    }

    console.log('Initialising Audio Player...');

    this.uniqueId = utils.uniqueIds.get('audio', doc);
    this.$elm = $elm;
    this.$elm.id = this.uniqueId;
    this.$audioElement = this.$elm.querySelector('audio');
    this.$playButton = AudioPlayer.buildPlayButton(this);
    this.$icon = this.$playButton.querySelector('.audio-player__toggle_play_icon');
    this.$possibleProgressTrack = AudioPlayer.buildProgressIndicator(this);
    this.$progressBar = this.$possibleProgressTrack.querySelector('[class*="progress_bar"]');
    this.$timeIndicators = AudioPlayer.buildTimeIndicators(this);
    this.$currentTime = this.$timeIndicators.querySelector('[class*="current_time"]');
    this.$duration = this.$timeIndicators.querySelector('[class*="duration"]');

    if (!this.$audioElement) {
      console.warn('No audio element found');
      return;
    }

    // state
    this.duration = null;
    this.isPlaying = false;

    // setup
    this.$elm.classList.add('audio-player--js');

    // events
    this.$playButton.addEventListener('click', function () {
      _this.togglePlay(_this.$audioElement, _this.$playButton);
    }, false);

    this.$audioElement.addEventListener('loadedmetadata', function () {
      _this.duration = _this.$audioElement.duration;
      _this.$duration.innerHTML = AudioPlayer.secondsToMinutes(_this.duration);
    });

    this.$audioElement.addEventListener('timeupdate', this.update.bind(this));
  }

  /**
   * Converts seconds to a display of minutes & seconds.
   *
   * @param {Number} seconds The time to convert, in seconds
   * @returns {string} The time in a [m]m:ss string
   */


  _createClass(AudioPlayer, [{
    key: 'togglePlay',


    //noinspection JSValidateJSDoc
    /**
     * Toggles play/pause state of media file.
     *
     * @param {HTMLAudioElement} $audioElement The audio element to toggle the play state of
     * @param {HTMLButtonElement} $togglePlayButton The button controlling the playback
     */
    value: function togglePlay($audioElement, $togglePlayButton) {
      if (this.isPlaying) {
        $audioElement.pause();
        AudioPlayer.updateIconState(this.$icon, 'play');
        $togglePlayButton.classList.add('audio-player__toggle_play--playable');
        $togglePlayButton.classList.remove('audio-player__toggle_play--pauseable');
        this.isPlaying = false;
      } else {
        $audioElement.play();
        AudioPlayer.updateIconState(this.$icon, 'pause');
        $togglePlayButton.classList.add('audio-player__toggle_play--pauseable');
        $togglePlayButton.classList.remove('audio-player__toggle_play--playable');
        this.isPlaying = true;
      }
    }

    /**
     * Update the progress bar and elapsed time indicator based on track's current time.
     */

  }, {
    key: 'update',
    value: function update() {
      var pc = this.$audioElement.currentTime / this.duration * 100;
      var currentTime2Dis = AudioPlayer.secondsToMinutes(Math.floor(this.$audioElement.currentTime));
      this.$progressBar.style.width = pc + '%';
      this.$currentTime.innerHTML = currentTime2Dis;

      if (this.$audioElement.ended) {
        AudioPlayer.updateIconState(this.$icon, 'play');
        this.isPlaying = false;
      }
    }

    /**
     * Updates the icon state for the play button.
     *
     * @param $icon {HTMLImageElement} The img to update
     * @param state {string} The state to update to (either 'play' or 'pause')
     */

  }, {
    key: 'handleSeek',


    /**
     * Event handler to determine track seek time in response to user interaction.
     *
     * @param e The user-generated click event
     * @param {AudioPlayer} player The audio player object that the new element belongs to
     */
    value: function handleSeek(e, player) {
      var newSeekPosition = parseInt(e.offsetX, 10);
      var availableWidth = player.$possibleProgressTrack.clientWidth;
      var durationProportionToSeek = newSeekPosition / parseInt(availableWidth, 10);
      this.seek(durationProportionToSeek * player.duration, player.$audioElement);
    }

    //noinspection JSValidateJSDoc
    /**
     * Seeks a particular time in the media file.
     *
     * @param {Number} time The time to seek
     * @param {HTMLAudioElement} $audioElement The audio element to toggle the play state of
     */

  }, {
    key: 'seek',
    value: function seek(time, $audioElement) {
      $audioElement.currentTime = time;
      this.update();
    }

    /**
     * Builds the progress indicator.
     *
     * @param {AudioPlayer} player The audio player object that the new element belongs to
     * @returns {Element} The progress indicator
     */

  }], [{
    key: 'secondsToMinutes',
    value: function secondsToMinutes(seconds) {
      var _seconds = parseInt(seconds, 10);
      var mins = Math.floor(_seconds / 60);
      var secs = _seconds % 60;
      if (secs <= 9) {
        secs = '0' + secs;
      }

      return mins + ':' + secs;
    }
  }, {
    key: 'updateIconState',
    value: function updateIconState($icon, state) {
      if (state !== 'play' && state !== 'pause') {

        return;
      }

      $icon.src = AudioPlayer.getIconPath(state);
      $icon.alt = state;
    }
  }, {
    key: 'buildProgressIndicator',
    value: function buildProgressIndicator(player) {
      var $barWrapper = utils.buildElement('div', ['audio-player__progress'], '', '#' + player.uniqueId + ' [class*="audio-player__container"]');

      utils.buildElement('div', ['audio-player__progress_bar'], '', $barWrapper);

      $barWrapper.addEventListener('click', function (e) {
        player.handleSeek(e, player);
      }, false);

      return $barWrapper;
    }

    /**
     * Builds the play button.
     *
     * @param {AudioPlayer} player The audio player object that the new element belongs to
     * @returns {Element} The play/pause button
     */

  }, {
    key: 'buildPlayButton',
    value: function buildPlayButton(player) {
      var $button = utils.buildElement('button', ['audio-player__toggle_play'], '', '#' + player.uniqueId + ' [class*="audio-player"]', true);
      var $image = utils.buildElement('img', ['audio-player__toggle_play_icon'], '', $button);
      $image.src = AudioPlayer.getIconPath('play');
      $image.alt = 'Play';
      return $button;
    }

    /**
     * Builds the current time and duration indicators.
     *
     * @param {AudioPlayer} player The audio player object that the new element belongs to
     * @returns {Element} An element containing the current time and duration indicators.
     */

  }, {
    key: 'buildTimeIndicators',
    value: function buildTimeIndicators(player) {
      var playerId = player.uniqueId;
      var $container = utils.buildElement('div', ['audio-player__times'], '', '#' + playerId + ' [class*=audio-player__header]', true);

      utils.buildElement('span', ['audio-player__current_time'], '0:00', $container);
      utils.buildElement('span', ['audio-player__duration'], '0:00', $container);
      return $container;
    }
  }, {
    key: 'getIconPath',
    value: function getIconPath(iconName) {

      if (iconName !== 'play' && iconName !== 'pause') {
        return;
      }

      return '../../assets/img/icons/audio-' + iconName + '.svg';
    }
  }]);

  return AudioPlayer;
}();

},{"../libs/elife-utils":9}],3:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

module.exports = function () {

  // Passing window and document separately allows for independent mocking of window in order
  // to test feature support fallbacks etc.

  function ContentHeaderArticle($elm) {
    var _window = arguments.length <= 1 || arguments[1] === undefined ? window : arguments[1];

    var doc = arguments.length <= 2 || arguments[2] === undefined ? document : arguments[2];

    _classCallCheck(this, ContentHeaderArticle);

    if (!$elm) {
      return;
    }

    this.window = _window;
    this.doc = doc;
    this.$elm = $elm;
    this.$elm.classList.add('content-header-article--js');

    // Should track SASS variable $bkpt-content-header.
    this.breakpointInPx = 560;
    this.currentView = this.calcCurrentView(this.breakpointInPx);

    this.authors = $elm.querySelectorAll('.content-header__author_list_item');
    this.institutions = $elm.querySelectorAll('.content-header__institution_list_item');

    this.hasToggleAuthor = false;
    this.hasToggleInstitution = false;
    this.hideAllExcessItems('author', this.authors);
    this.hideAllExcessItems('institution', this.institutions);

    var _this = this;
    this.window.addEventListener('resize', function () {
      var newView = _this.calcCurrentView(_this.breakpointInPx);
      if (newView !== _this.currentView) {
        _this.currentView = newView;
        _this.handleAnyExcessItems('author', _this.authors);
        _this.handleAnyExcessItems('institution', _this.institutions);
      }
    });
  }

  _createClass(ContentHeaderArticle, [{
    key: 'handleAnyExcessItems',
    value: function handleAnyExcessItems(itemType, items) {
      var toggle = this.$elm.querySelector('.content-header__item_toggle');
      if (toggle && toggle.innerHTML.indexOf('less') > -1 && this.currentView === 'wide') {
        this.clearExcessMark(items);
        this.toggleExcessItems(items);
      } else {
        this.clearExcessMark(items);
        var excessItems = this.getExcessItems(itemType, items);
        this.markAsExcess(excessItems);
        this.toggleExcessItems(items);
        this.markLastNonExcessItem(itemType, items);
      }
    }

    /**
     * Determine excess by itemType from items supplied and hides those.
     *
     * @param {string} itemType 'author' or 'institution'
     * @param {DOMTokenList} items List of items to identify the excess within, and hide those
     */

  }, {
    key: 'hideAllExcessItems',
    value: function hideAllExcessItems(itemType, items) {
      var excessItems = this.getExcessItems(itemType, items);
      this.markAsExcess(excessItems);
      this.toggleExcessItems(items);
      this.addTrailingText(itemType, items);
    }

    /**
     * Returns max number authors or institutions to be displayed by default at current screen width.
     *
     * Returns null if itemType is invalid.
     *
     * @param {string} itemType 'author' or 'institution'
     * @returns {number|null} Number of the type of item to display by default at current screen width
     */

  }, {
    key: 'getDefaultMaxItems',
    value: function getDefaultMaxItems(itemType) {
      if (this.currentView === 'wide') {
        if (itemType === 'author') {
          return 16;
        }

        if (itemType === 'institution') {
          return 10;
        }
      } else {
        if (itemType === 'author') {
          return 1;
        }

        if (itemType === 'institution') {
          return 0;
        }
      }

      return null;
    }

    /**
     * Returns array of elements in excess of the default max items, or null if itemType invalid.
     *
     * The returned array is a subset of the list supplied, or empty if there are no excess items.
     *
     * @param {string} itemType 'author' or 'institution'
     * @param {DOMTokenList} items List of items from which to identify the excess
     * @returns {Array|null} Items in excess of the default maximum for the current screen width
     */

  }, {
    key: 'getExcessItems',
    value: function getExcessItems(itemType, items) {
      if (itemType !== 'author' && itemType !== 'institution') {
        return null;
      }

      var defaultMaxItems = this.getDefaultMaxItems(itemType);
      if (items.length > defaultMaxItems) {
        return [].slice.call(items, defaultMaxItems);
      }

      return [];
    }

    /**
     * Marks supplied list elements as excess.
     *
     * @param {Array} els The elements to mark as excess
     */

  }, {
    key: 'markAsExcess',
    value: function markAsExcess(els) {
      els.forEach(function ($el) {
        $el.classList.add('excess-item');
      });
    }

    /**
     * Clears any excess mark from all elements in the supplied list.
     *
     * @param {DOMTokenList} els The elements to clear the excess mark from
     */

  }, {
    key: 'clearExcessMark',
    value: function clearExcessMark(els) {
      [].forEach.call(els, function ($el) {
        $el.classList.remove('excess-item');
      });
    }

    /**
     * Toggles the display of any excess items found in the supplied list of elements.
      * @param {DOMTokenList} items The elements to inspect for excess items, and to toggle those found
     */

  }, {
    key: 'toggleExcessItems',
    value: function toggleExcessItems(items) {
      [].forEach.call(items, function (item) {
        if (item.classList.contains('excess-item')) {
          item.classList.add('visuallyhidden');
        } else {
          item.classList.remove('visuallyhidden');
        }
      });
    }

    /**
     * Returns the name of the current view.
     *
     * @param {number} breakpoint The px viewport width that determines the view.
     *
     * @returns {string} the view name ('wide' or 'narrow').
     */

  }, {
    key: 'calcCurrentView',
    value: function calcCurrentView(breakpoint) {
      return this.window.matchMedia('(min-width: ' + breakpoint + 'px)').matches ? 'wide' : 'narrow';
    }

    /**
     * Marks the last shown non-excess item with particlular class (so not if showing last in list).
     *
     * @param {string} itemType 'author' or 'institution'
     * @param {DOMTokenList} items List of items to act upon
     */

  }, {
    key: 'markLastNonExcessItem',
    value: function markLastNonExcessItem(itemType, items) {
      var lastShownIndex = null;
      var foundLastShown = false;
      [].forEach.call(items, function (item, i) {

        // Clear old any obsolete determination of what's the last non-excess item.
        items[i].classList.remove('content-header__' + itemType + '--last-non-excess');
        if (item.classList.contains('excess-item') && !foundLastShown) {
          lastShownIndex = i - 1;
          foundLastShown = true;
        }
      });

      if (lastShownIndex !== null && lastShownIndex > -1) {
        var lastShown = items[lastShownIndex].querySelector('.content-header__' + itemType);
        if (lastShown) {
          lastShown.classList.add('content-header__' + itemType + '--last-non-excess');
        }
      }
    }

    /**
     * Adds trailing text to the visible end of truncated author & institution lists & builds toggle.
     *
     * @param {string} itemType The type of items supplied
     * @param {DOMTokenList} items The items to which to add the trailing text
     */

  }, {
    key: 'addTrailingText',
    value: function addTrailingText(itemType, items) {
      if (itemType === 'author' && items.length > this.getDefaultMaxItems('author')) {
        if (!this.hasToggleAuthor) {
          this.buildSeeMoreLessToggle('author');
          this.hasToggleAuthor = true;
        }
      }

      if (itemType === 'institution' && items.length > this.getDefaultMaxItems('institution')) {
        if (!this.hasToggleInstitution) {
          this.buildSeeMoreLessToggle('institution');
          this.hasToggleInstitution = true;
        }
      }

      this.markLastNonExcessItem(itemType, items);
    }

    /**
     * Builds the show/hide toggle for excess authors & institutions.
     */

  }, {
    key: 'buildSeeMoreLessToggle',
    value: function buildSeeMoreLessToggle(itemType) {
      var _this2 = this;

      // This toggle only required due to screen width constraints. All content already accessible as
      // it's not being hidden in the first place. Hence an aria-hidden li, rather than an anchor.
      // Should conform to https://www.w3.org/TR/wai-aria/states_and_properties#aria-hidden
      var toggle = this.doc.createElement('li');
      var toggleOnText = 'see&nbsp;all';
      var toggleOffText = 'see&nbsp;less';
      toggle.setAttribute('aria-hidden', 'true');
      toggle.classList.add('content-header__item_toggle', 'content-header__item_toggle--' + itemType);
      toggle.innerHTML = '&nbsp;&hellip;&nbsp;' + toggleOnText;
      toggle.addEventListener('click', function (e) {
        var target = e.target;
        if (target.innerHTML.indexOf(toggleOnText) > -1) {
          [].forEach.call(_this2.doc.querySelectorAll('.content-header__item_toggle'), function (item) {
            item.innerHTML = '&nbsp;' + toggleOffText;
          });
          _this2.clearExcessMark(_this2.authors);
          _this2.clearExcessMark(_this2.institutions);
          _this2.toggleExcessItems(_this2.authors);
          _this2.toggleExcessItems(_this2.institutions);
        } else {
          [].forEach.call(_this2.doc.querySelectorAll('.content-header__item_toggle'), function (item) {
            item.innerHTML = '&nbsp;&hellip;&nbsp;' + toggleOnText;
          });
          _this2.hideAllExcessItems('author', _this2.authors);
          _this2.hideAllExcessItems('institution', _this2.institutions);
        }
      });
      this.$elm.querySelector('.content-header__' + itemType + '_list').appendChild(toggle);
    }
  }]);

  return ContentHeaderArticle;
}();

},{}],4:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

module.exports = function () {

  // Passing window and document separately allows for independent mocking of window in order
  // to test feature support fallbacks etc.

  function MainMenu($elm) {
    var _window = arguments.length <= 1 || arguments[1] === undefined ? window : arguments[1];

    var doc = arguments.length <= 2 || arguments[2] === undefined ? document : arguments[2];

    _classCallCheck(this, MainMenu);

    if (!$elm) {
      return;
    }

    this.window = _window;
    this.doc = doc;
    this.$elm = $elm;
  }

  /**
   * Moves main menu from default non-js DOM position into position required by js implementation.
   */


  _createClass(MainMenu, [{
    key: 'moveWithinDom',
    value: function moveWithinDom() {
      this.$elm.classList.add('main-menu--js');
      var $globalWrapper = this.doc.querySelector('.global-wrapper');
      if (!!$globalWrapper) {
        $globalWrapper.insertBefore(this.$elm, $globalWrapper.firstElementChild);
      }
    }

    /**
     * Indicates whether the main menu is currently open.
     *
     * @returns {boolean} true if the main menu is currently open
     */

  }, {
    key: 'isOpen',
    value: function isOpen() {
      return this.$elm.classList.contains('main-menu--shown');
    }

    /**
     * Closes the main menu
     */

  }, {
    key: 'close',
    value: function close() {
      this.$elm.classList.remove('main-menu--shown');
      this.doc.querySelector('.global-wrapper').classList.remove('pull-offscreen-right');
    }

    /**
     * Opens the main menu
     */

  }, {
    key: 'open',
    value: function open() {
      this.$elm.classList.add('main-menu--shown');
      this.doc.querySelector('.global-wrapper').classList.add('pull-offscreen-right');
    }
  }]);

  return MainMenu;
}();

},{}],5:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var utils = require('../libs/elife-utils')();

module.exports = function () {

  // Passing window and document separately allows for independent mocking of window in order
  // to test feature support fallbacks etc.

  function SearchBox($elm) {
    var _this = this;

    var _window = arguments.length <= 1 || arguments[1] === undefined ? window : arguments[1];

    var doc = arguments.length <= 2 || arguments[2] === undefined ? document : arguments[2];

    _classCallCheck(this, SearchBox);

    if (!$elm) {
      return;
    }

    this.$container = $elm.querySelector('fieldset');
    this.$form = $elm.querySelector('form');
    this.$input = $elm.querySelector('input[type="search"]');
    this.$limit = $elm.querySelector('input[type="checkbox"]');
    this.$elm = $elm;
    this.$searchButton = $elm.querySelector('button[type="submit"]');
    this.$resetButton = $elm.querySelector('button[type="reset"]');
    this.$inner = $elm.querySelector('.search-box__inner');

    // Check there's a search input field, if not everything else is pointless.
    if (!this.$input) {
      return;
    }

    // TODO: Remove if not ultimately useful.
    this.isSearchLimited = this.$limit && this.$limit.checked;

    this.$elm.classList.add('search-box--js');

    // setup
    this.$form.setAttribute('autocomplete', 'off');

    if (!doc.querySelector('.search-box__output')) {
      this.$output = doc.createElement('div');
      this.$output.innerHTML = '';
      this.$output.classList.add('search-box__output');
      this.$output.addEventListener('keyup', function (e) {
        SearchBox.handleKeyEntry(e, _this);
      });
      this.$output.addEventListener('click', function (e) {
        _this.useSuggestion(e.target);
      });
      this.$inner.appendChild(this.$output);
    }

    this.keywords = [];

    // events
    this.$resetButton.addEventListener('click', this.reset.bind(this));
    this.$input.addEventListener('keyup', function (e) {
      SearchBox.handleKeyEntry(e, _this);
    });
    this.$input.addEventListener('paste', this.showResetButton.bind(this));

    // TODO: Remove this test data when decided how to populate this list of keywords with real data
    SearchBox.setKeywords(['Xiao-Dong Li', 'Zhijian J Chen', 'Cell biology', 'Immunology', 'bacteria'], this);
  }

  /**
   * Handles the reset button being pressed.
   */


  _createClass(SearchBox, [{
    key: 'reset',
    value: function reset() {
      this.hideResetButton();
      if (this.$output) {
        this.$output.innerHTML = '';
      }

      this.$input.focus();
    }

    /**
     * Hides the reset button.
     */

  }, {
    key: 'hideResetButton',
    value: function hideResetButton() {
      this.$elm.classList.remove('search-box--populated');
    }

    /**
     * Shows the reset button.
     */

  }, {
    key: 'showResetButton',
    value: function showResetButton() {
      this.$elm.classList.add('search-box--populated');
    }

    /**
     * Responds to the keyCode of a KeyboardEvent (used on the input field and suggestions).
     *
     * Takes care not to trap the tab character. Accessibility!
     * Down arrow (keyCode 40): go to the next suggestion.
     * Up arrow (keyCode 38): go to the previous suggestion.
     * Return (keyCode 13): put the text of the current suggestion into the search box
     * Any other key: use it to filter keywords; also show/hide reset button.
     *
     * @param {KeyboardEvent} e The event to respond to
     * @param {SearchBox} searchBox Calling object (injected to make method more testable)
     */

  }, {
    key: 'nextSuggestion',


    /**
     * Selects the search suggestion element after the current one.
     *
     * If already on the last one, loop to the beginning and select the input field.
     *
     * @param {HTMLElement} current The search suggestion or input field currently with focus
     */
    value: function nextSuggestion(current) {
      if (!this.$output) {
        return;
      }

      if (current === this.$input) {
        this.$output.querySelector('ul li:first-child').focus();
      } else if (!!current.nextElementSibling) {
        current.nextElementSibling.focus();
      } else {
        this.$input.focus();
      }
    }

    /**
     * Selects the search suggestion element before the current one.
     *
     * If already on the input field, loop to the end and select the last one.
     *
     * @param {HTMLElement} current The search suggestion or input field currently with focus
     */

  }, {
    key: 'prevSuggestion',
    value: function prevSuggestion(current) {
      if (!this.$output) {
        return;
      }

      if (current === this.$input) {
        this.$output.querySelector('ul li:last-child').focus();
      } else if (!!current.previousElementSibling) {
        current.previousElementSibling.focus();
      } else {
        this.$input.focus();
      }
    }

    /**
     * Copy the display text of the current suggestion into the search field.
     *
     * @param {HTMLElement} target The element containing the text to use
     */

  }, {
    key: 'useSuggestion',
    value: function useSuggestion(target) {
      this.$input.value = target.innerHTML.replace(/<\/?strong>/g, '');
      if (this.$output) {
        this.$output.innerHTML = '';
        if (this.$input.value.length) {
          this.$form.submit();
        }
      }
    }

    /**
     * Gets the keywords for the supplied searchBox.
     *
     * @param {SearchBox} searchBox The injected search box
     */

  }, {
    key: 'filterKeywordsBySearchTerm',


    /**
     * Filter keywords by the contents of the search field.
     *
     * @param {string} searchTerm The search term to filter the keywords by
     * @param {Array} keywords The keywords to filter
     */
    value: function filterKeywordsBySearchTerm(keywords, searchTerm) {
      var matches = void 0;
      if (searchTerm) {
        matches = keywords.filter(function (keyword) {
          return keyword.toLowerCase().indexOf(searchTerm.toLowerCase()) !== -1;
        });

        matches.sort();
        for (var i = 0; i < matches.length; i += 1) {
          matches[i] = SearchBox.embolden(matches[i], searchTerm);
        }
      }

      return matches;
    }

    /**
     * Returns phrase with specified (case insensitive) snippet emboldened.
     *
     * @param {string} phrase The phrase containing the text to embolden
     * @param {string} snippet The substring of phrase to embolden
     * @returns {string} The phrase with the snippet emboldened
     */

  }, {
    key: 'display',


    /**
     * Update the search suggestions based on matches found.
     *
     * @param {Array} matches The matches found
     * @param {HTMLElement} $output Element to contain the display
     */
    value: function display(matches, $output) {
      var outputString = '';

      if ($output) {
        $output.innerHTML = '';
        this.nudgeOutputVertically('-47px');

        if (matches && matches.length) {
          matches.forEach(function (match) {
            outputString += '<li tabindex="0" class="search-box__suggestion">' + match + '</li>';
          });

          outputString = '<ul>' + outputString + '</ul>';
          $output.innerHTML = outputString;
        }
      }
    }

    /**
     * Uses css transform to translate $output in the vertical axis.
     *
     * @param posnInPx The vertical offset to apply
     */

  }, {
    key: 'nudgeOutputVertically',
    value: function nudgeOutputVertically(posnInPx) {
      var posn = void 0;
      if (typeof posnInPx === 'string' && posnInPx.indexOf('px') === posnInPx.length - 2) {
        posn = posnInPx;
      } else if (!isNaN(posnInPx)) {
        posn = posnInPx + 'px';
      }

      utils.updateElementTranslate(this.$output, [0, posn]);
    }

    /**
     * Toggle the flag that limits the search.
     */

  }, {
    key: 'toggleSearchLimiting',
    value: function toggleSearchLimiting() {
      this.isSearchLimited = !this.isSearchLimited;
    }
  }], [{
    key: 'handleKeyEntry',
    value: function handleKeyEntry(e, searchBox) {
      var current = e.target;
      if (e.keyCode && e.keyCode !== 9) {
        switch (e.keyCode) {
          case 40:
            searchBox.nextSuggestion(current);
            break;
          case 38:
            searchBox.prevSuggestion(current);
            break;
          case 13:
            searchBox.useSuggestion(current);
            break;
          default:
            searchBox.display(searchBox.filterKeywordsBySearchTerm(SearchBox.getKeywords(searchBox), searchBox.$input.value), searchBox.$output);
            if (searchBox.$input.value.length > 0) {
              searchBox.showResetButton();
            } else {
              searchBox.hideResetButton();
            }

            break;
        }
      }
    }
  }, {
    key: 'getKeywords',
    value: function getKeywords(searchBox) {
      return searchBox.keywords;
    }

    /**
     * Sets the keywords for the supplied searchBox.
     *
     * @param {Array} keywords The keywords for the searchBox
     * @param {SearchBox} searchBox The injected search box
     */

  }, {
    key: 'setKeywords',
    value: function setKeywords(keywords, searchBox) {
      searchBox.keywords = keywords;
    }
  }, {
    key: 'embolden',
    value: function embolden(phrase, snippet) {
      // Don't nest emboldening elements.
      if (snippet.indexOf('<strong>') > -1) {
        return phrase;
      }

      var snippetRx = new RegExp(snippet, 'i');
      var toEmbolden = phrase.match(snippetRx) ? phrase.match(snippetRx)[0] : null;
      if (!toEmbolden) {
        return phrase;
      }

      return phrase.replace(toEmbolden, '<strong>' + toEmbolden + '</strong>');
    }
  }]);

  return SearchBox;
}();

},{"../libs/elife-utils":9}],6:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

module.exports = function () {
  function SelectNav($elm) {
    _classCallCheck(this, SelectNav);

    if (!$elm) {
      return;
    }

    this.$elm = $elm;
    this.$elm.classList.add('select-nav--js');
    this.$elm.querySelector('select').addEventListener('change', this.triggerSubmit.bind(this));
  }

  _createClass(SelectNav, [{
    key: 'triggerSubmit',
    value: function triggerSubmit() {
      this.$elm.submit();
    }
  }]);

  return SelectNav;
}();

},{}],7:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var utils = require('../libs/elife-utils')();

module.exports = function () {

  // Passing window and document separately allows for independent mocking of window in order
  // to test feature support fallbacks etc.

  function SiteHeader($elm) {
    var _window = arguments.length <= 1 || arguments[1] === undefined ? window : arguments[1];

    var doc = arguments.length <= 2 || arguments[2] === undefined ? document : arguments[2];

    _classCallCheck(this, SiteHeader);

    if (!$elm) {
      return;
    }

    this.$elm = $elm;
    this.window = _window;
    this.doc = doc;

    var SearchBox = require('./SearchBox');
    var $searchBoxEl = $elm.querySelector('[data-behaviour="SearchBox"]');
    this.searchBox = new SearchBox($searchBoxEl, this.window, doc);
    var searchToggle = $elm.querySelector('[rel="search"]');
    if (!!searchToggle) {
      this.searchToggle = searchToggle.parentNode;
      this.searchToggle.addEventListener('click', this.toggleSearchBox.bind(this));
    }

    this.$pageOverlay = null;

    // N.B. $mainMenu is not part of this component's HTML hierarchy.
    var mainMenu = doc.querySelector('#mainMenu');
    if (!!mainMenu) {
      var MainMenu = require('./MainMenu');
      this.mainMenu = new MainMenu(mainMenu);

      this.$mainMenuToggle = this.$elm.querySelector('a[href="#mainMenu"]');
      if (!!this.$mainMenuToggle) {
        this.mainMenu.moveWithinDom();
        this.$mainMenuToggle.addEventListener('click', this.toggleMainMenu.bind(this));
      }
    }
  }

  /**
   * Toggles display of the main menu.
   */


  _createClass(SiteHeader, [{
    key: 'toggleMainMenu',
    value: function toggleMainMenu(e) {
      if (this.mainMenu.isOpen()) {
        this.mainMenu.close();
        this.window.removeEventListener('keyup', this.checkForMenuClose.bind(this));
        this.window.removeEventListener('click', this.checkForMenuClose.bind(this));
      } else {
        this.mainMenu.open();
        this.window.addEventListener('keyup', this.checkForMenuClose.bind(this));
        this.window.addEventListener('click', this.checkForMenuClose.bind(this));
      }

      e.preventDefault();
      e.stopPropagation();
    }
  }, {
    key: 'checkForMenuClose',
    value: function checkForMenuClose(e) {
      if (e.keyCode === 27 || e.type === 'click' && !utils.areElementsNested(this.mainMenu.$elm, e.target)) {
        this.mainMenu.close();
      }
    }

    /**
     * Toggles display of the search box.
     *
     * @param {Event} e The event causing the toggle to occur
     */

  }, {
    key: 'toggleSearchBox',
    value: function toggleSearchBox(e) {
      e.preventDefault();
      e.stopPropagation();
      if (this.searchBoxIsOpen()) {
        this.closeSearchBox();
      } else {
        this.openSearchBox();
      }
    }

    /**
     * Returns true if the search box is currently displayed.
     *
     * @returns {boolean} True if the search box is open
     */

  }, {
    key: 'searchBoxIsOpen',
    value: function searchBoxIsOpen() {
      return this.searchBox.$elm.classList.contains('search-box--shown');
    }

    /**
     * Closes the search box.
     */

  }, {
    key: 'closeSearchBox',
    value: function closeSearchBox() {
      this.searchBox.$elm.classList.remove('search-box--shown');
      utils.updateElementTranslate(this.searchBox.$elm, [0, '-40px']);
      if (this.searchBox.$output) {
        this.searchBox.$output.innerHTML = '';
      }

      this.searchBox.$input.blur();
      this.window.removeEventListener('keyup', this.checkForClose.bind(this));
      this.window.removeEventListener('click', this.checkForClose.bind(this));
      this.hidePageOverlay();
    }

    /**
     * Decides whether to close the search box, based on the supplied event.
     *
     * @param e The KeyboardEvent provoking the check.
     */

  }, {
    key: 'checkForClose',
    value: function checkForClose(e) {
      if (e.keyCode && e.keyCode === 27 || e.type === 'click' && !utils.areElementsNested(this.searchBox.$elm, e.target)) {
        this.closeSearchBox();
      }
    }

    /**
     * Opens the search box.
     */

  }, {
    key: 'openSearchBox',
    value: function openSearchBox() {
      var _this = this;

      var myHeight = this.window.getComputedStyle(this.$elm).height;
      var adjustment = 20;
      var offsetY = utils.adjustPxString(myHeight, adjustment);

      // This is set in the site-header.scss.
      var transitionDurationInMs = 150;
      utils.updateElementTranslate(this.searchBox.$elm, [0, offsetY]);
      utils.invertPxString(this.window.getComputedStyle(this.searchBox.$container).height);
      this.searchBox.$elm.classList.add('search-box--shown');
      this.window.addEventListener('keyup', this.checkForClose.bind(this));
      this.window.addEventListener('click', this.checkForClose.bind(this));

      this.window.setTimeout(function () {

        // blur before focus forces the focus, a simple focus doesn't always behave as expected.
        _this.searchBox.$input.blur();
        _this.searchBox.$input.focus();
      }, transitionDurationInMs);
      this.showPageOverlay();
    }

    /**
     * Creates the page overlay.
     *
     */

  }, {
    key: 'createPageOverlay',
    value: function createPageOverlay() {
      var className = 'overlay--semi-white';

      if (!this.$pageOverlay) {
        this.$pageOverlay = this.doc.createElement('div');
        this.$pageOverlay.classList.add(className);
      }

      var $target = this.doc.querySelector('.global-inner');
      $target.insertBefore(this.$pageOverlay, this.doc.querySelector('.site-header').nextElementSibling);
    }

    /**
     * Shows the page overlay.
     */

  }, {
    key: 'showPageOverlay',
    value: function showPageOverlay() {
      if (!this.$pageOverlay) {
        this.createPageOverlay();
      }

      this.$pageOverlay.style.display = 'block';
      this.$pageOverlay.style.height = this.doc.querySelector('.global-inner').getBoundingClientRect().height + 'px';
    }

    /**
     * Hides the page overlay.
     */

  }, {
    key: 'hidePageOverlay',
    value: function hidePageOverlay() {
      this.$pageOverlay.style.display = 'none';
    }
  }]);

  return SiteHeader;
}();

},{"../libs/elife-utils":9,"./MainMenu":4,"./SearchBox":5}],8:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

module.exports = function () {
  function ViewerModal($elm) {
    _classCallCheck(this, ViewerModal);

    this.$elm = $elm;
    this.$prev = document.createElement('div');
    this.$next = document.createElement('div');

    // build the modal
    this.build();

    // events
    this.$prev.addEventListener('click', this.prev);
    this.$next.addEventListener('click', this.next);
  }

  _createClass(ViewerModal, [{
    key: 'build',
    value: function build() {
      //
    }
  }, {
    key: 'prev',
    value: function prev(e) {
      e.preventDefault();
    }
  }, {
    key: 'next',
    value: function next(e) {
      e.preventDefault();
    }
  }, {
    key: 'close',
    value: function close() {
      //
    }
  }]);

  return ViewerModal;
}();

},{}],9:[function(require,module,exports){
'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

module.exports = function () {
  'use strict';

  /**
   * Builds and returns specified HTML element, optionally adding it to the DOM.
   *
   * @param {string} elName Name of the HTML element to build
   * @param {Array} [cssClasses] CSS class name(s) to set on the element
   * @param {string} [textContent] Textual content of the element
   * @param {string|Element} [parent] Parent element to attach to
   * @param {string|Element|boolean} [attachBefore] Following sibling (1st if true, last if falsey)
   *
   * @returns {Element}
   */

  function buildElement(elName, cssClasses, textContent, parent, attachBefore) {

    var $el = document.createElement(elName);
    var $parent = typeof parent === 'string' ? document.querySelector(parent) : parent;

    // Work out what the new element's following sibling will be, based on value of attachBefore.
    var $followingSibling = function () {

      if (!!attachBefore) {

        if (typeof attachBefore === 'boolean') {
          return $parent.firstElementChild;
        } else if (typeof attachBefore === 'string') {
          return document.querySelector(attachBefore);
        } else if (attachBefore instanceof HTMLElement) {
          return attachBefore;
        }
      }
    }();

    cssClasses.forEach(function (cssClass) {
      $el.classList.add(cssClass);
    });

    if (textContent) {
      $el.innerHTML = textContent;
    }

    if (!!$parent && !!$followingSibling) {
      $parent.insertBefore($el, $followingSibling);
    } else {
      $parent.appendChild($el);
    }

    return $el;
  }

  var uniqueIds = function uniqueIds() {
    var UniqueIdentifiers = function () {
      function UniqueIdentifiers() {
        _classCallCheck(this, UniqueIdentifiers);

        this.used = [];
      }

      _createClass(UniqueIdentifiers, [{
        key: 'isValid',
        value: function isValid(candidate, document) {
          // Compulsory check that id is unique to this object's knowledge.
          if (this.used.indexOf(candidate) > -1) {
            return false;
          }

          // Optional check to see if id is unique in the DOM.
          if (!!document) {
            if (!!document.querySelector && typeof document.querySelector === 'function' && document.querySelector('#' + candidate)) {
              return false;
            }
          }

          return true;
        }

        /**
         * Gets a unique id with optional prefix.
         *
         * @param {string} [prefix] Prefix to use for the id
         * @param {HTMLDocument} [document] Enables checking for the id's uniqueness within the DOM
         * @returns {string}
         */

      }, {
        key: 'get',
        value: function get(prefix, document) {
          var _prefix = '' + prefix || 'default_';
          var random = ('' + Math.random()).replace(/\./, '');
          var candidate = _prefix + random;
          if (this.isValid(candidate)) {
            return candidate;
          }

          this.get(prefix, document);
        }
      }]);

      return UniqueIdentifiers;
    }();

    return new UniqueIdentifiers();
  }();

  /**
   * Updates the CSS transform's translate function on the element in a vendor-prefix-aware fashion.
   *
   * Because of the way CSS transformations are combined into a matrix, this may not work
   * as expected if other CSS transformations are also applied to the same element.
   *
   * @param {HTMLElement} $el The element to apply the transformation to.
   * @param {Array} offset The offset for both axes, expressed as [x, y], e.g. [0, '20px']
   */
  function updateElementTranslate($el, offset) {
    if (!($el instanceof HTMLElement && Array.isArray(offset))) {
      return;
    }

    var props = ['webkitTransform', 'mozTransform', 'msTransform', 'oTransform', 'transform'];
    var offsetX = offset[0];
    var offsetY = offset[1] || 0;

    props.forEach(function (prop) {
      $el.style[prop] = 'translate(' + offsetX + ', ' + offsetY + ')';
    });
  }

  /**
   * Add a quantity to a px amount expressed as a string, and return new string with updated value.
   *
   * For example: adjustPxString('97px', 8) returns '105px'
   *
   * @param {String} pxString The string representing the original quantity, e.g. '97px'
   * @param adjustment The numeric adjustment to make, e.g. 8
   * @returns {string} The modified value, as a string, e.g.: '105px'
   */
  function adjustPxString(pxString, adjustment) {
    var originalSize = parseInt(pxString.match(/([-0-9.]+)px/)[1], 10);
    var newSize = originalSize + adjustment;
    return newSize + 'px';
  }

  /**
   * Invert the px amount expressed as a string, and return new string with inverted value.
   *
   * For example: invertPxString('97px') returns '-97px'
   *
   * @param {String} pxString The string representing the original quantity, e.g. '97px'
   * @returns {string} The modified value, as a string, e.g.: '-97px'
   */
  function invertPxString(pxString) {
    var originalSize = parseInt(pxString.match(/([-0-9.]+)px/)[1], 10);
    var newSize = originalSize * -1;
    return newSize + 'px';
  }

  /**
   * Returns true if $prospectiveDescendant is, or is a descendant of $prospectiveParent.
   *
   * @param {HTMLElement} $prospectiveParent el to test as a parent of the $prospectiveDescendant
   * @param {HTMLElement} $prospectiveDescendant el to test as descendant of the $prospectiveParent
   * @returns {boolean} Whether the s$prospectiveDescendant is, or descends from $prospectiveParent
   */
  function areElementsNested($prospectiveParent, $prospectiveDescendant) {
    var relationship = $prospectiveParent.compareDocumentPosition($prospectiveDescendant);
    return !!(relationship & $prospectiveParent.DOCUMENT_POSITION_CONTAINED_BY || relationship === 0);
  }

  /**
   * Return the current viewport width.
   *
   * @returns {number} The current viewport width
   */
  function getViewportWidth() {
    return document.documentElement.clientWidth;
  }

  return {
    adjustPxString: adjustPxString,
    areElementsNested: areElementsNested,
    buildElement: buildElement,
    getViewportWidth: getViewportWidth,
    invertPxString: invertPxString,
    uniqueIds: uniqueIds,
    updateElementTranslate: updateElementTranslate
  };
};

},{}],10:[function(require,module,exports){
'use strict';

// Base level of feature support needed for the js loaded in this file.
// Consider AJAXing in the rest if the test passes.

if (window.localStorage && document.querySelector && window.addEventListener && !!document.createElement('div').classList) {
  (function () {

    document.querySelector('html').classList.add('js');

    var Components = {};

    // import modules into the list of Components.
    Components.ArticleDownloadLinksList = require('./components/ArticleDownloadLinksList');
    Components.AudioPlayer = require('./components/AudioPlayer');
    Components.ContentHeaderArticle = require('./components/ContentHeaderArticle');
    Components.SelectNav = require('./components/SelectNav');
    Components.MainMenu = require('./components/MainMenu');
    Components.SiteHeader = require('./components/SiteHeader');
    Components.SearchBox = require('./components/SearchBox');
    Components.ViewerModal = require('./components/ViewerModal');

    // App
    var Elife = function Elife() {

      // get all the components on the current page
      var components = document.querySelectorAll('[data-behaviour]');

      if (components.length) {

        for (var i = 0; i < components.length; i += 1) {
          var $elm = components[i];
          var handler = $elm.getAttribute('data-behaviour');

          // Is there a handler?
          // Is it a function?
          if (Components[handler] && typeof Components[handler] === 'function') {
            new Components[handler]($elm, window, window.document);
          }
        }
      }
    };

    new Elife();
  })();
}

},{"./components/ArticleDownloadLinksList":1,"./components/AudioPlayer":2,"./components/ContentHeaderArticle":3,"./components/MainMenu":4,"./components/SearchBox":5,"./components/SelectNav":6,"./components/SiteHeader":7,"./components/ViewerModal":8}]},{},[10])


//# sourceMappingURL=main.js.map

'use strict';

module.exports = class Math {

  constructor($elm, _window = window, doc = document) {
    this.window = _window;
    this.isSingleton = true;

    Math.init(doc);
  }

  static init(doc) {
    Math.loadDependencies(doc);
    if ('MutationObserver' in window) {
      if (!Math.dependenciesAlreadySetup(doc)) {
        let observer = new MutationObserver((mutations, observer) => {
          Math.loadDependencies(doc);
          if (Math.dependenciesAlreadySetup(doc)) {
            observer.disconnect();
          }
        });
        observer.observe(doc.body, { childList: true, subtree: true });
      }
    }
  }

  static loadDependencies(doc) {
    if (doc.querySelector('math')) {
      Math.flattenSingleRowMtable(doc);
      Math.normalizeLegacyMathVariants(doc);
      Math.setupProperties();
      Math.load(doc);
    }
  }

  // Some equations are wrongly created using a single row mtable element which makes line breaking impossible
  // This function flattens them i.e. pulls the elements of the mrow into the parent container
  static flattenSingleRowMtable(root) {
    root.querySelectorAll('math').forEach(math => {
      const mtable = math.querySelector('mtable');
      if (!mtable) return;
      if (mtable.querySelectorAll('mtr').length !== 1) return;

      const doc = math.ownerDocument;
      const mrow = doc.createElementNS('http://www.w3.org/1998/Math/MathML', 'mrow');
      mtable.querySelectorAll('mtd').forEach(cell => {
        while (cell.firstChild) mrow.appendChild(cell.firstChild);
      });

      while (math.firstChild) math.removeChild(math.firstChild);
      math.setAttribute('display', 'block');
      math.appendChild(mrow);
    });
  }

  // MathJax v2 used private mathvariant values (prefixed -tex-) that v4 doesn't recognise.
  // Remap them to their standard MathML equivalents before MathJax processes the elements.
  static normalizeLegacyMathVariants(root) {
    const map = {
      'MJX-tex-caligraphic':   'script',
      'MJX-tex-calligraphic':  'script',
      'MJX-bold-caligraphic':  'bold-script',
      'MJX-bold-calligraphic': 'bold-script',
      'MJX-tex-oldstyle':      'normal',
    };
    Object.entries(map).forEach(([cls, mathvariant]) => {
      root.querySelectorAll(`.${cls}`).forEach(el => {
        el.setAttribute('mathvariant', mathvariant);
        el.removeAttribute('class');
        const mathEl = el.closest('math');
        if (mathEl) mathEl.setAttribute('data-has-legacy-variant', '');
      });
    });
  }

  // MathJax v4's displayOverflow: 'linebreak' only fires for <math display="block">.
  // Equations authored with <mstyle displaystyle="true"> are intended as display-style but
  // lack the attribute, so v4 never line-breaks them. This marks them as block-level so
  // the v4 line-breaker applies.
  static markDisplayStyleMathAsBlock(root) {
    root.querySelectorAll('math:not([display="block"])').forEach(math => {
      const firstChild = math.firstElementChild;
      if (firstChild && firstChild.tagName === 'mstyle' && firstChild.getAttribute('displaystyle') === 'true') {
        math.setAttribute('display', 'block');
      }
    });
  }

  // MathJax falls back to mjx-utext (raw Unicode + font-size correction) when the active font
  // lacks a glyph for a variant (e.g. bold-script). The correction factor is calculated against
  // generic font metrics and renders too large in Firefox. Reset it after typesetting.
  static fixLegacyVariantScale(doc) {
    if (!/Firefox/.test(navigator.userAgent)) return;
    doc.querySelectorAll('mjx-utext').forEach(utext => {
      utext.style.fontSize = '1em';
    });
  }

  static dependenciesAlreadySetup(doc) {
    return !!doc.querySelector('script[src*="mathjax"]');
  }

  static setupProperties() {
    window.mathFlattenSingleRowMtable = (root) => Math.flattenSingleRowMtable(root || document);
    window.MathJax = {
      startup: {
        ready() {
          Math.flattenSingleRowMtable(document);
          Math.markDisplayStyleMathAsBlock(document);
          MathJax.startup.defaultReady();
        },
        pageReady() {
          return MathJax.startup.defaultPageReady()
            .then(() => Math.fixLegacyVariantScale(document));
        },
      },
      options: {
        skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre']
      },
      output: {
        // Required when using Noto Serif as body font, for other fonts YMMV.
        scale: (function () {

          // Noto Serif's ex height is marginally larger than the font it replaces. The slight
          // down scaling of the maths set in basicScaling (90%) tries to keep the equation size similar
          // to how it was with the previous font, in case line breaks within equations are significant.
          const basicScaling = 0.9;

          // Work around for a bug causing inconsistent maths sizing between browsers:
          // Some browsers display the maths legibly with the basic scaling, other browsers
          // require it to be scaled up.
          const upScaling = basicScaling * 2;

          function shouldBeScaledUp() {
            const ua = navigator.userAgent;
            const isMac = /Macintosh/.test(ua);
            const isPC = /Windows/.test(ua);
            const isSafari = /Safari\//.test(ua) && !/Chrome\//.test(ua);
            const isChrome = /Chrome\//.test(ua);
            const isFirefox = /Firefox\//.test(ua);
            const isIE = /Trident|MSIE/.test(ua);

            // Required because maths scales differently between iOS & Android platforms in Chrome
            // and Safari, and navigator.userAgent doesn't reliably distinguish the mobile OS.
            // Deliberately not made available as a utility: we don't want to encourage this!
            const isProbablyIOS = /iPad|iPhone/.test(ua);

            // Don't scale up if any of the following applies:
            return !(

                // IE
                isIE ||

                // Safari or Chrome on a Mac
                (isMac && (isSafari || isChrome)) ||

                // Safari or Chrome on iOS
                (isProbablyIOS && isSafari) ||

                // Aiming to target Firefox on Linux & mobile
                (isFirefox && !(isMac || isPC))

            );
          }
          return shouldBeScaledUp() ? upScaling : basicScaling;
        }()),
        displayOverflow: 'linebreak',
        font: 'mathjax-tex',
        mathmlSpacing: true,
        linebreaks: {
          inline: true,
          width: /Firefox/.test(navigator.userAgent) ? '40%' : '90%',
          lineleading: 0.2,
          LinebreakVisitor: null,
        },
      }
    };
  }

  static setupResizeHandler() {
    let currentClientWidth = document.body.clientWidth;
    let resizeTimeout;
    window.addEventListener('resize', function () {
      if (!resizeTimeout) {
        resizeTimeout = setTimeout(function () {
          resizeTimeout = null;
          if (window.MathJax && window.MathJax.typesetPromise && currentClientWidth !== document.body.clientWidth) {
            currentClientWidth = document.body.clientWidth;
            window.MathJax.typesetClear();
            window.MathJax.typesetPromise();
          }
        }, 300);
      }
    });
  }

  static load(doc) {
    if (Math.dependenciesAlreadySetup(doc)) {
      return;
    }
    let script = doc.createElement('script');
    script.type = 'text/javascript';
    script.addEventListener('load', Math.setupResizeHandler);
    script.src = 'https://cdn.jsdelivr.net/npm/mathjax@4.1.2/mml-chtml.js';
    script.integrity = 'sha384-/2ITe67wlF1iItSD3V+4xUIuJTAnyo0xJ8xoMMZzAIEdrmtnsuVe7uaHpkLBDV97';
    script.crossOrigin = 'anonymous';
    doc.querySelector('body').appendChild(script);
  }
};

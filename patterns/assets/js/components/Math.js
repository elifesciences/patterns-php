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

  static dependenciesAlreadySetup(doc) {
    return !!doc.querySelector('script[src*="mathjax"]');
  }

  static setupProperties() {
    window.mathFlattenSingleRowMtable = (root) => Math.flattenSingleRowMtable(root || document);
    window.MathJax = {
      startup: {
        ready() {
          Math.flattenSingleRowMtable(document);
          MathJax.startup.defaultReady();
        }
      },
      options: {
        skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre']
      },
      output: {
        scale: /Firefox/.test(navigator.userAgent) ? 1.9 : 1,
        displayOverflow: 'linebreak',
        mathmlSpacing: true,
        font: 'mathjax-newcm',
        linebreaks: {
          inline: true,
          width: /Firefox/.test(navigator.userAgent) ? '60%' : '100%',
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

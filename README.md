eLife Patterns
==============

[![Build Status](http://ci--alfred.elifesciences.org/buildStatus/icon?job=library-patterns-php)](http://ci--alfred.elifesciences.org/job/library-patterns-php/)

This library provides a PHP implementation for the Mustache templates/assets produced by the [eLife Sciences Pattern Library](https://github.com/elifesciences/pattern-library).

Dependencies
------------

* [Composer](https://getcomposer.org/)
* [Puli CLI](http://puli.io)
* PHP 7

Installation
------------

Execute `composer require elife/patterns:dev-master`.

Versioning
----------

This library is _not_ versioned as the eLife Patterns can make breaking changes at any time. It's not expected to be used by libraries, but by applications where Composer lock files are used. These tie the application to a specific commit.

Usage
-----

Create `ViewModel`s and pass them to a `PatternRenderer`, which will return the rendered template.

For example:

```php
use eLife\Patterns\Mustache\PatternLabLoader;
use eLife\Patterns\Mustache\PuliLoader;
use eLife\Patterns\PatternRenderer\MustachePatternRenderer;

$helpers = ['assetsPath' => $puliUrlGenerator->generateUrl('/elife/patterns/assets')];
$puliLoader = new PuliLoader($puliRepository);
$patternLabLoader = new PatternLabLoader($puliRepository->get('/elife/patterns/templates')->getFilesystemPath());

$mustache = new Mustache_Engine([
    'helpers' => $helpers,
    'loader' => $puliLoader,
    'partials_loader' => $patternLabLoader,
]);
$patternRenderer = new MustachePatternRenderer($mustache);

var_dump($patternRenderer->render($viewModel));
```

Template loading
----------------

The library provides two Mustache loaders:

1. `PuliLoader` loads templates from a Puli repository.
2. `PatternLabLoader` loads templates from the filesystem

Mustache should be configured to use them as the primary and partial loader respectively.

Asset handling
--------------

As well as providing complete CSS/JavaScript files (eg `/elife/patterns/assets/css/all.css`), the patterns also state which individual assets they require. They can also provide inline CSS and JavaScript.

Use the `AssetRecordingPatternRenderer` to record which assets are used and include them on the page as necessary.

For example:

```php
use eLife\Patterns\PatternRenderer\AssetRecordingPatternRenderer;
use eLife\Patterns\PatternRenderer\MustachePatternRenderer;

$patternRenderer = new AssetRecordingPatternRenderer(new MustachePatternRenderer($mustache));

$patternRenderer->render($viewModel);

var_dump($patternRenderer->getStyleSheets());
```

Updating the library
--------------------

1. Install [Compass](http://compass-style.org/).
2. Execute `bin/update` to update the `resources` folder from Pattern Lab (you can pass a commit if needed, eg `bin/update baa62f0`).
3. Make changes to the view models accordingly.

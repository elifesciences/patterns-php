eLife Patterns
==============

[![Build Status](http://ci--alfred.elifesciences.org/buildStatus/icon?job=library-patterns-php)](http://ci--alfred.elifesciences.org/job/library-patterns-php/)

This library provides a PHP implementation for the Mustache templates/assets produced by the [eLife Sciences Pattern Library](https://github.com/elifesciences/pattern-library).

Dependencies
------------

* [Composer](https://getcomposer.org/)
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
use eLife\Patterns\PatternRenderer\MustachePatternRenderer;

$helpers = [
    'assetsPath' => '/path/to/assets',
    'assetRewrite' => function (string $path, Mustache_LambdaHelper $helper) : string {
        return $helper->render($path).'?cache-buster';
    },
];

$mustache = new Mustache_Engine([
    'helpers' => $helpers,
    'loader' => new Mustache_Loader_FilesystemLoader('/path/to/patterns-php'),
]);
$patternRenderer = new MustachePatternRenderer($mustache);

var_dump($patternRenderer->render($viewModel));
```

Asset handling
--------------

As well as providing complete CSS/JavaScript files (eg `resources/assets/css/all.css`), the patterns also state which individual assets they require. They can also provide inline JavaScript.

Use the `AssetRecordingPatternRenderer` to record which assets are used and include them on the page as necessary.

For example:

```php
use eLife\Patterns\PatternRenderer\AssetRecordingPatternRenderer;
use eLife\Patterns\PatternRenderer\MustachePatternRenderer;

$patternRenderer = new AssetRecordingPatternRenderer(new MustachePatternRenderer($mustache));

$patternRenderer->render($viewModel);

var_dump($patternRenderer->getJavaScripts());
```

Updating the library
--------------------

1. Install [Docker](https://www.docker.com/).
2. Execute `bin/update` to update the `resources` folder from Pattern Lab (you can pass a commit or pull request if needed, eg `bin/update 4303c0199112724bd5725537c7192828099018fb` or `bin/update pr-850`).
3. Make changes to the view models accordingly.

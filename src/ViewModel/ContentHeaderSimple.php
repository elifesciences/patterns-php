<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ContentHeaderSimple implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $title;
    private $strapline;

    public function __construct(string $title, string $strapline = null)
    {
        Assertion::notBlank($title);

        $this->title = $title;
        $this->strapline = $strapline;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-header-simple.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/content-header-simple.css';
    }
}

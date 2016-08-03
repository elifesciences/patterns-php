<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ViewSelector implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $articleUrl;
    private $jumpLinks;
    private $figureUrl;

    public function __construct(string $articleUrl, array $jumpLinks, string $figureUrl = null)
    {
        Assertion::notBlank($articleUrl);
        Assertion::allIsInstanceOf($jumpLinks, Link::class);

        $this->articleUrl = $articleUrl;
        $this->jumpLinks = $jumpLinks;
        $this->figureUrl = $figureUrl;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/view-selector.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/view-selector.css';
    }
}

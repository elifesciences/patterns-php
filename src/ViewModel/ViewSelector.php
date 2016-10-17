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
    private $sideBySideUrl;

    public function __construct(
        string $articleUrl,
        array $jumpLinks = [],
        string $figureUrl = null,
        string $sideBySideUrl = null
    ) {
        Assertion::notBlank($articleUrl);
        Assertion::allIsInstanceOf($jumpLinks, Link::class);
        if (count($jumpLinks) > 0) {
            Assertion::min(count($jumpLinks), 2);
        }

        $this->articleUrl = $articleUrl;
        if (count($jumpLinks) > 0) {
            $this->jumpLinks = ['links' => $jumpLinks];
        }
        $this->figureUrl = $figureUrl;
        $this->sideBySideUrl = $sideBySideUrl;
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

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ViewSelector implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $articleUrl;
    private $jumpLinks;
    private $figureUrl;
    private $figureIsActive;
    private $sideBySideUrl;

    public function __construct(
        string $articleUrl,
        array $jumpLinks = [],
        string $figureUrl = null,
        bool $figureIsActive = false,
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
        if ($this->figureUrl && $figureIsActive) {
            $this->figureIsActive = $figureIsActive;
        }
        $this->sideBySideUrl = $sideBySideUrl;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/view-selector.mustache';
    }
}

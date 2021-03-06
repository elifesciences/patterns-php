<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class ViewSelector implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $articleUrl;
    private $jumpLinks;
    private $figureUrl;
    private $figureIsActive;
    private $otherLinks;
    private $sideBySideUrl;

    public function __construct(
        string $articleUrl,
        array $jumpLinks = [],
        string $figureUrl = null,
        bool $figureIsActive = false,
        string $sideBySideUrl = null,
        array $otherLinks = []
    ) {
        Assertion::notBlank($articleUrl);
        Assertion::allIsInstanceOf($jumpLinks, Link::class);
        if (count($jumpLinks) > 0) {
            Assertion::min(count($jumpLinks), 2);
        }
        Assertion::allIsInstanceOf($otherLinks, Link::class);

        $this->articleUrl = $articleUrl;
        if (count($jumpLinks) > 0) {
            $this->jumpLinks = ['links' => $jumpLinks];
        }
        $this->figureUrl = $figureUrl;
        if ($this->figureUrl && $figureIsActive) {
            $this->figureIsActive = $figureIsActive;
        }
        $this->sideBySideUrl = $sideBySideUrl;
        $this->otherLinks = $otherLinks;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/view-selector.mustache';
    }
}

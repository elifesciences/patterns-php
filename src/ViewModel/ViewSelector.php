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

    private $primaryUrl;
    private $primaryLabel;
    private $jumpLinks;
    private $secondaryUrl;
    private $secondaryLabel;
    private $secondaryIsActive;
    private $otherLinks;
    private $sideBySideUrl;
    /**
     * @var string
     */

    public function __construct(
        string $primaryUrl,
        string $primaryLabel,
        array $jumpLinks = [],
        string $secondaryUrl = null,
        string $secondaryLabel = null,
        bool $secondaryIsActive = false,
        string $sideBySideUrl = null,
        array $otherLinks = []
    ) {
        Assertion::notBlank($primaryUrl);
        Assertion::notBlank($primaryLabel);
        Assertion::allIsInstanceOf($jumpLinks, Link::class);
        if (count($jumpLinks) > 0) {
            Assertion::min(count($jumpLinks), 2);
        }
        Assertion::allIsInstanceOf($otherLinks, Link::class);

        $this->primaryUrl = $primaryUrl;
        $this->primaryLabel = $primaryLabel;
        if (count($jumpLinks) > 0) {
            $this->jumpLinks = ['links' => $jumpLinks];
        }
        $this->secondaryUrl = $secondaryUrl;
        $this->secondaryLabel = $secondaryLabel;
        if ($this->secondaryUrl && $secondaryIsActive) {
            $this->secondaryIsActive = $secondaryIsActive;
        }
        $this->sideBySideUrl = $sideBySideUrl;
        $this->otherLinks = $otherLinks;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/view-selector.mustache';
    }
}

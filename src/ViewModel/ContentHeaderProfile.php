<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ContentHeaderProfile implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $details;
    private $displayName;
    private $miscLinks;
    private $logoutLink;


    public function __construct(string $displayName, array $logoutLink, array $miscLinks = [], array $details = [])
    {
        Assertion::notEmpty($displayName);
        Assertion::notBlank($logoutLink);

        $this->displayName = $displayName;
        $this->details = $details;
        $this->logoutLink = $this->createLinks($logoutLink);
        $this->miscLinks = $this->createLinks($miscLinks);
    }

    private function createLinks(array $linkData)
    {

    }

    public function getTemplateName() : string
    {
        return 'resources/templates/content-header-profile.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/content-header-profile.css';
    }
}

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
    private $secondaryLinks;
    private $logoutLink;

    public function __construct(string $displayName, Link $logoutLink = null, array $secondaryLinks = [], array $affiliations = [], string $emailAddress = null)
    {
        Assertion::notEmpty($displayName);
        Assertion::allIsInstanceOf($secondaryLinks, Link::class);

        $this->displayName = $displayName;
        $this->details = $this->createDetails($affiliations, $emailAddress);
        $this->logoutLink = $logoutLink;
        $this->secondaryLinks = $secondaryLinks;
    }

    private function createDetails(array $affiliations = [], string $emailAddress = null)
    {
        $details = [];

        if (!empty($affiliations)) {
            $details['affiliations'] = $affiliations;
        }

        if ($emailAddress) {
            $details['emailAddress'] = $emailAddress;
        }

        if (!empty($details)) {
            return $details;
        }

        return null;
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

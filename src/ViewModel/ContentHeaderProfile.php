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

    public function __construct(string $displayName, array $logoutLink, array $secondaryLinks = [], array $affiliations = [], string $emailAddress = '')
    {
        Assertion::notEmpty($displayName);
        Assertion::notBlank($logoutLink);


        $this->displayName = $displayName;
        $this->details = $this->createDetails($affiliations, $emailAddress);
        $this->logoutLink = $this->createLinks($logoutLink)[0];
        $this->secondaryLinks = $this->createLinks($secondaryLinks);
    }

    private function createDetails(array $affiliations = [], string $emailAddress = '')
    {
        $details = [];

        if (!empty($affiliations)) {
            $details['affiliations'] = $affiliations;
        }

        if (!empty($emailAddress)) {
            $details['emailAddress'] = $emailAddress;
        }

        if (!empty($details)) {
            return $details;
        }

        return null;

    }

    public function createLinks(array $linkData)
    {
        $links = [];

        foreach ($linkData as $text => $uri) {
            array_push($links, ['text' => $text, 'uri' => $uri]);
        }

        return $links;
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

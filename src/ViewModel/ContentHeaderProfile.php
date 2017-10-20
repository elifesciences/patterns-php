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
        Assertion::true(count($details) < 3);
        if (!empty($details)) {
            foreach (array_keys($details) as $key) {
                Assertion::choice($key, ['affiliations', 'emailAddress']);
            }
        }

        $this->displayName = $displayName;
        $this->details = $details;
        $this->logoutLink = $this->createLinks($logoutLink)[0];
        $this->miscLinks = $this->createLinks($miscLinks);
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

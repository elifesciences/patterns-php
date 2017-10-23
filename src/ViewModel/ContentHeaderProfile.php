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

    private function __construct()
    {
    }

    public static function loggedIn(
        string $displayName,
        Link $logoutLink = null,
        array $secondaryLinks = [],
        array $affiliations = [],
        string $emailAddress = null
    ) : ContentHeaderProfile {
        Assertion::notEmpty($displayName);
        Assertion::allIsInstanceOf($secondaryLinks, Link::class);

        $loggedInContentHeaderProfile = new static();
        $loggedInContentHeaderProfile->displayName = $displayName;
        $loggedInContentHeaderProfile->details = $loggedInContentHeaderProfile->createDetails($affiliations, $emailAddress);
        $loggedInContentHeaderProfile->logoutLink = $logoutLink;
        $loggedInContentHeaderProfile->secondaryLinks = $secondaryLinks;

        return $loggedInContentHeaderProfile;
    }

    public static function notLoggedIn(
        string $displayName,
        array $affiliations = [],
        string $emailAddress = null

    ) : ContentHeaderProfile {
        Assertion::notEmpty($displayName);

        $notLoggedInContentHeaderProfile = new static();
        $notLoggedInContentHeaderProfile->displayName = $displayName;
        $notLoggedInContentHeaderProfile->details = $notLoggedInContentHeaderProfile->createDetails($affiliations, $emailAddress);

        return $notLoggedInContentHeaderProfile;
    }

    private static function createDetails(array $affiliations = [], string $emailAddress = null)
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

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ProfileLoginControl implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $button;
    private $displayName;
    private $isLoggedIn;
    private $logoutUri;
    private $profileHomeLink;
    private $profileManageLink;

    private function __construct()
    {
    }

    public static function loggedIn (
        string $profileHomeLink,
        string $displayName,
        string $profileManageLink,
        string $logoutUri
    ) : ProfileLoginControl {

        Assertion::notBlank($profileHomeLink);
        Assertion::notBlank($displayName);
        Assertion::notBlank($profileManageLink);
        Assertion::notBlank($logoutUri);

        $loggedInControl = new static();
        $loggedInControl->isLoggedIn = true;
        $loggedInControl->displayName = $displayName;
        $loggedInControl->profileHomeLink = $profileHomeLink;
        $loggedInControl->profileManageLink = $profileManageLink;
        $loggedInControl->logoutUri = $logoutUri;

        return $loggedInControl;
    }

    public static function notLoggedIn (string $uri) : ProfileLoginControl
    {
        Assertion::notBlank($uri);

        $notLoggedInControl = new static();
        $notLoggedInControl->isLoggedIn = null;
        $notLoggedInControl->button = Button::link('Log in / Register', $uri, Button::SIZE_EXTRA_SMALL, Button::STYLE_CONFIRM);

        return $notLoggedInControl;
    }

    public function getStyleSheets(): Traversable
    {
        yield 'resources/assets/css/profile-login-control.css';
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/profile-login-control.mustache';
    }
}

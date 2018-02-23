<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class HypothesisLoader implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $usernameUrl;
    private $hypothesisApiUrl;
    private $hypothesisAuthority;
    private $iconPath;
    private $loginPath;
    private $profilePath;
    private $logoutPath;
    private $grantToken;

    private function __construct(
        string $usernameUrl,
        string $hypothesisApiUrl,
        string $hypothesisAuthority,
        string $iconPath,
        string $loginPath = null,
        string $profilePath = null,
        string $logoutPath = null,
        string $grantToken = null
    ) {
        Assertion::notBlank($usernameUrl);
        Assertion::notBlank($hypothesisApiUrl);
        Assertion::notBlank($hypothesisAuthority);
        Assertion::notBlank($iconPath);

        $this->usernameUrl = $usernameUrl;
        $this->hypothesisApiUrl = $hypothesisApiUrl;
        $this->hypothesisAuthority = $hypothesisAuthority;
        $this->iconPath = $iconPath;
        $this->loginPath = $loginPath;
        $this->profilePath = $profilePath;
        $this->logoutPath = $logoutPath;
        $this->grantToken = $grantToken;
    }

    public static function loggedOut(
        string $usernameUrl,
        string $hypothesisApiUrl,
        string $hypothesisAuthority,
        string $iconPath,
        string $loginPath,
        string $grantToken = null
    ) : HypothesisLoader {
        Assertion::notBlank($loginPath);

        return new static($usernameUrl, $hypothesisApiUrl, $hypothesisAuthority, $iconPath, $loginPath, null, null, $grantToken);
    }

    public static function loggedIn(
        string $usernameUrl,
        string $hypothesisApiUrl,
        string $hypothesisAuthority,
        string $iconPath,
        string $profilePath,
        string $logoutPath,
        string $grantToken = null
    ) : HypothesisLoader {
        Assertion::notBlank($profilePath);
        Assertion::notBlank($logoutPath);

        return new static($usernameUrl, $hypothesisApiUrl, $hypothesisAuthority, $iconPath, null, $profilePath, $logoutPath, $grantToken);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/hypothesis-loader.mustache';
    }
}

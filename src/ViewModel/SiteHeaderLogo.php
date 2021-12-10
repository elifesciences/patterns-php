<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class SiteHeaderLogo implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $homePagePath;

    public function __construct(string $homePagePath)
    {
        Assertion::notBlank($homePagePath);

        $this->homePagePath = $homePagePath;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/site-header-logo.mustache';
    }
}

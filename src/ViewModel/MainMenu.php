<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class MainMenu implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $mainMenuLinks;

    public function __construct(array $mainMenuLinks)
    {
        Assertion::notEmpty($mainMenuLinks);
        Assertion::allIsInstanceOf($mainMenuLinks, MainMenuLink::class);

        $this->mainMenuLinks = $mainMenuLinks;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/main-menu.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/main-menu.css';
    }
}

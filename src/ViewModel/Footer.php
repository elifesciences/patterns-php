<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Footer implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $_mainMenu;

    private $year;
    private $assetsPath;
    private $mainMenuLinks;
    private $footerMenuLinks;

    public function __construct(
        string $assetsPath,
        MainMenu $mainMenu,
        array $footerMenuLinks
    ) {
        Assertion::notBlank($assetsPath);
        Assertion::notEmpty($footerMenuLinks);
        Assertion::allIsInstanceOf($footerMenuLinks, Link::class);

        $this->year = (int) date('Y');
        $this->assetsPath = $assetsPath;
        $this->_mainMenu = $mainMenu;
        $this->mainMenuLinks = $mainMenu['mainMenuLinks'];
        $this->footerMenuLinks = $footerMenuLinks;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/footer.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/site-footer.css';
        yield $this->_mainMenu->getStyleSheets();
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Footer implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $_mainMenu;

    private $year;
    private $mainMenu;
    private $listHeading;
    private $links;
    private $button;
    private $footerMenuLinks;

    public function __construct(
        MainMenu $mainMenu,
        array $footerMenuLinks
    ) {
        Assertion::notEmpty($footerMenuLinks);
        Assertion::allIsInstanceOf($footerMenuLinks, Link::class);

        $this->year = (int) date('Y');
        $this->_mainMenu = $mainMenu;
        $this->mainMenu = true;
        $this->listHeading = $mainMenu['listHeading'];
        $this->links = $mainMenu['links'];
        $this->button = $mainMenu['button'];
        $this->footerMenuLinks = $footerMenuLinks;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/footer.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/site-footer.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->_mainMenu;
    }
}

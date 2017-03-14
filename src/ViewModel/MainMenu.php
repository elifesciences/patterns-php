<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class MainMenu implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $links;
    private $button;

    public function __construct(array $links)
    {
        Assertion::notEmpty($links);
        Assertion::allIsInstanceOf($links, Link::class);

        $this->links = ['items' => $links];

        $button = Button::link('Back to top', '#siteHeader', Button::SIZE_SMALL, Button::STYLE_DEFAULT, true,
            true);
        $button = FlexibleViewModel::fromViewModel($button);
        $classes = $button['classes'];
        $this->button = $button->withProperty('classes', $classes.' main_menu__quit');
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/main-menu.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/main-menu.css';
    }
}

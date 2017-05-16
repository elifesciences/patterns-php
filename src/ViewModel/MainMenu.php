<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class MainMenu implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $links;
    private $listHeading;

    public function __construct(array $links)
    {
        Assertion::notEmpty($links);
        Assertion::allIsInstanceOf($links, Link::class);

        $this->links = ['items' => $links];
        $this->listHeading = new ListHeading('Menu');
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/main-menu.mustache';
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/main-menu.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->listHeading;
    }
}

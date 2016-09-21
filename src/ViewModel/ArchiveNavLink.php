<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class ArchiveNavLink implements ViewModel
{
    use ArrayFromProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    private $blockLink;
    private $label;
    private $links;

    public function __construct(BlockLink $blockLink, string $label, array $links)
    {
        Assertion::notBlank($label);
        Assertion::notEmpty($links);
        Assertion::allIsInstanceOf($links, Link::class);

        $this->blockLink = $blockLink;
        $this->label = $label;
        $this->links = $links;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/archive-nav-link.mustache';
    }

    protected function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/archive-nav-link.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->blockLink;
    }
}

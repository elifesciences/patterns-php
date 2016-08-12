<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class MiniSection implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $body;
    private $listHeading;

    public function __construct(string $body, ListHeading $listHeading = null)
    {
        Assertion::notBlank($body);

        $this->body = $body;
        $this->listHeading = $listHeading;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/mini-section.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/mini-section.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->listHeading;
    }
}

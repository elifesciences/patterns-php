<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class MiniSection implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

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

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/mini-section.css';
        if ($this->listHeading) {
            yield from $this->listHeading->getStyleSheets();
        } else {
            yield from (new ListHeading('dummy'))->getStyleSheets();
        }
    }
}

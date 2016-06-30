<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ListHeading implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $heading;

    public function __construct(string $heading)
    {
        Assertion::notBlank($heading);

        $this->heading = $heading;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/list-heading.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/list-heading.mustache';
    }
}

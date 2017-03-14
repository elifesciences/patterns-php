<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ListHeading implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $heading;

    public function __construct(string $heading)
    {
        Assertion::notBlank($heading);

        $this->heading = $heading;
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/list-heading.css';
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/list-heading.mustache';
    }
}

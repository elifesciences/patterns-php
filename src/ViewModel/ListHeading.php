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
    private $headingId;

    public function __construct(string $heading, string $headingId = null)
    {
        Assertion::notBlank($heading);

        $this->heading = $heading;
        $this->headingId = $headingId;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/list-heading.mustache';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Math implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $math;
    private $id;
    private $label;

    public function __construct(string $math, string $id = null, string $label = null)
    {
        Assertion::regex($math, '/^<math>[\s\S]+<\/math>$/');

        $this->math = $math;
        $this->id = $id;
        $this->label = $label;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/math.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/math.css';
    }
}

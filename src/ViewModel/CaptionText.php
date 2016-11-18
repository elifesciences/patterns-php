<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class CaptionText implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $heading;
    private $standFirst;
    private $text;

    public function __construct(string $heading, string $standFirst = null, string $text = null)
    {
        Assertion::notBlank($heading);

        $this->heading = $heading;
        $this->standFirst = $standFirst;
        $this->text = $text;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/caption-text.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/caption-text.css';
    }
}

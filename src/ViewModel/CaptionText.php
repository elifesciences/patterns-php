<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class CaptionText implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $heading;
    private $standfirst;
    private $text;

    public function __construct(string $heading, string $standfirst = null, string $text = null)
    {
        Assertion::notBlank($heading);

        $this->heading = $heading;
        $this->standfirst = $standfirst;
        $this->text = $text;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/caption-text.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/caption-text.css';
    }
}

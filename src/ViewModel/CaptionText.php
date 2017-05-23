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

    private function __construct(string $heading = null, string $standfirst = null, string $text = null)
    {
        $this->heading = $heading;
        $this->standfirst = $standfirst;
        $this->text = $text;
    }

    public static function withHeading(string $heading, string $standfirst = null, string $text = null) : CaptionText
    {
        Assertion::notBlank($heading);

        return new self($heading, $standfirst, $text);
    }

    public static function withOutHeading(string $text, string $standfirst = null) : CaptionText
    {
        Assertion::notBlank($text);

        return new self(null, $standfirst, $text);
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

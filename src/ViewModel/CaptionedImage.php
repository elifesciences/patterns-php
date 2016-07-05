<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class CaptionedImage implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    protected $heading;
    protected $caption;
    protected $picture;

    public function __construct(string $heading, string $caption, Picture $picture)
    {
        Assertion::notBlank($heading);
        Assertion::notBlank($caption);

        $this->heading = $heading;
        $this->caption = $caption;
        $this->picture = $picture;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/captioned-image.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/captioned-image.mustache';
    }
}

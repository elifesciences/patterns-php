<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class IFrame implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $id;
    private $src;
    private $width;
    private $height;
    private $allowFullScreen;

    public function __construct(string $src, int $width, int $height, bool $allowFullScreen = true)
    {
        Assertion::notBlank($src);
        Assertion::min($width, 1);
        Assertion::min($height, 1);

        $this->id = hash('crc32', $src);
        $this->src = $src;
        $this->width = $width;
        $this->height = $height;
        $this->allowFullScreen = $allowFullScreen;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/iframe.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/iframe.css';
    }

    public function getInlineStyleSheets() : Traversable
    {
        yield '.iframe--'.$this->id.' {
    padding-bottom: '.(($this->height / $this->width) * 100).'%;
}';
    }
}

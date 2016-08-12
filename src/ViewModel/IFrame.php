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

    private $src;
    private $allowFullScreen;
    private $paddingBottom;

    public function __construct(string $src, int $width, int $height, bool $allowFullScreen = true)
    {
        Assertion::notBlank($src);
        Assertion::min($width, 1);
        Assertion::min($height, 1);

        $this->src = $src;
        $this->paddingBottom = ($height / $width) * 100;
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
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class MediaSource implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $src;
    private $mimeType;
    private $fallback;

    public function __construct(string $src, MimeType $mimeType, MediaSourceFallback $fallback = null)
    {
        Assertion::notBlank($src);

        $this->src = $src;
        $this->mimeType = $mimeType;
        $this->fallback = $fallback;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/media-source.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/media-source.css';
    }
}

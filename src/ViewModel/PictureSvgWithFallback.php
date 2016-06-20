<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class PictureSvgWithFallback implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $alt;
    private $defaultImage;
    private $fallbackSrcset;
    private $sources;

    public function __construct(string $alt, string $defaultImage, string $fallbackSrcset, array $sources)
    {
        Assertion::notBlank($defaultImage);
        Assertion::notBlank($fallbackSrcset);
        Assertion::notEmpty($sources);
        foreach ($sources as $source) {
            Assertion::keyExists($source, 'svg');
            if (isset($source['media'])) {
                Assertion::min(count($sources), 2);
            }
        }

        $this->alt = $alt;
        $this->defaultImage = $defaultImage;
        $this->fallbackSrcset = $fallbackSrcset;
        $this->sources = $sources;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/picture-svg-with-fallback.mustache';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class Picture implements ViewModel, IsCaptioned
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $fallback;
    private $sources;
    private $pictureClasses;

    public function __construct(array $sources, Image $fallback, array $classes = [])
    {
        Assertion::allIsInstanceOf($sources, PictureSource::class);

        $this->sources = $sources;
        $this->fallback = $fallback;
        $this->pictureClasses = $classes ? implode(' ', $classes) : null;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/picture.mustache';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class Picture implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $pictureClasses;
    private $fallback;
    private $sources;

    public function __construct(array $sources, Image $fallback, string $pictureClasses = null)
    {
        Assertion::notEmpty($sources);
        $nullMediaCount = 0;
        foreach ($sources as $source) {
            Assertion::isArray($source);
            if (empty($source['media'])) {
                ++$nullMediaCount;
            }
        }
        Assertion::max($nullMediaCount, 1);

        $this->sources = $sources;
        $this->fallback = $fallback;
        $this->pictureClasses = $pictureClasses;
    }

    public function addPictureClass(string $class) : Picture
    {
        $this->pictureClasses = trim($this->pictureClasses.' '.$class);

        return $this;
    }

    public function addFallbackClass(string $classes) : Picture
    {
        $this->fallback->addClass($classes);

        return $this;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/picture.mustache';
    }
}

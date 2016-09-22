<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class BackgroundImage implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $lowResImageSource;
    private $highResImageSource;
    private $thresholdWidth;

    public function __construct(string $lowResImageSource, string $highResImageSource, int $thresholdWidth = null)
    {
        Assertion::notBlank($lowResImageSource);
        Assertion::notBlank($highResImageSource);
        Assertion::nullOrMin($thresholdWidth, 0);

        $this->lowResImageSource = $lowResImageSource;
        $this->highResImageSource = $highResImageSource;
        $this->thresholdWidth = $thresholdWidth;
    }
}

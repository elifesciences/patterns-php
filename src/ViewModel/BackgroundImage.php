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

    public function __construct(string $lowResImageSource, string $highResImageSource)
    {
        Assertion::notBlank($lowResImageSource);
        Assertion::notBlank($highResImageSource);

        $this->lowResImageSource = $lowResImageSource;
        $this->highResImageSource = $highResImageSource;
    }
}

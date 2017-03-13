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

    public function __construct(array $sources, Image $fallback)
    {
        Assertion::allIsArray($sources);

        $this->sources = $sources;
        $this->fallback = $fallback;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/picture.mustache';
    }
}

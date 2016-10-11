<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class Picture implements ViewModel, IsCaptioned
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $fallback;
    private $sources;

    public function __construct(array $sources, Image $fallback)
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
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/picture.mustache';
    }
}

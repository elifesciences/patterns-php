<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class Picture implements ViewModel, IsImage
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

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

    protected function getComposedViewModels() : Traversable
    {
        yield $this->fallback;
    }
}

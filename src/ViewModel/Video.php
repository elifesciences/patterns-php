<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class Video implements ViewModel, IsCaptioned
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $posterFrame;
    /** @var MediaSource[] */
    private $sources;

    public function __construct(string $posterFrame, array $sources)
    {
        Assertion::notBlank($posterFrame);
        Assertion::notEmpty($sources);
        Assertion::allIsInstanceOf($sources, MediaSource::class);
        Assertion::allTrue(array_map(function (MediaSource $mediaSource) {
            return strpos($mediaSource['mediaType']['forMachine'], 'video') === 0;
        }, $sources), 'All sources must be video types.');

        $this->posterFrame = $posterFrame;
        $this->sources = $sources;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/video.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield from $this->sources;
    }
}

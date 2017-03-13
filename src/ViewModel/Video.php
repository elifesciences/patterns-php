<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Video implements ViewModel, IsCaptioned
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $posterFrame;
    /** @var MediaSource[] */
    private $sources;
    private $autoplay;
    private $loop;

    public function __construct(string $posterFrame, array $sources, bool $autoplay = false, bool $loop = false)
    {
        Assertion::notBlank($posterFrame);
        Assertion::notEmpty($sources);
        Assertion::allIsInstanceOf($sources, MediaSource::class);
        Assertion::allTrue(array_map(function (MediaSource $mediaSource) {
            return strpos($mediaSource['mediaType']['forMachine'], 'video') === 0;
        }, $sources), 'All sources must be video types.');

        $this->posterFrame = $posterFrame;
        $this->sources = $sources;
        if ($autoplay) {
            $this->autoplay = $autoplay;
        }
        if ($loop) {
            $this->loop = $loop;
        }
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

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class AudioPlayer implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    protected $title;
    /** @var AudioSource[] */
    protected $sources;

    public function __construct(string $title, array $sources)
    {
        Assertion::notBlank($title);
        Assertion::allIsInstanceOf($sources, AudioSource::class);

        $this->title = $title;
        $this->sources = $sources;
    }

    public function addSource(AudioSource $source) {
        $this->sources[] = $source;
    }

    public function getJavaScripts() : Traversable
    {
        return '/elife/patterns/assets/js/AudioPlayer.js';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/audio-player.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/audio-player.css';
    }
}

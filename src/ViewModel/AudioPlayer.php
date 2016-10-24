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

    private $episodeNumber;
    private $title;
    /** @var MediaSource[] */
    private $sources;
    private $metadata;

    public function __construct(int $episodeNumber, string $title, array $sources, array $chapters)
    {
        Assertion::min($episodeNumber, 1);
        Assertion::notBlank($title);
        Assertion::allIsInstanceOf($sources, MediaSource::class);
        Assertion::notEmpty($chapters);
        Assertion::allIsInstanceOf($chapters, MediaChapterListingItem::class);
        Assertion::allTrue(array_map(function (MediaSource $mediaSource) {
            return strpos($mediaSource['mediaType']['forMachine'], 'audio') === 0;
        }, $sources), 'All sources must be audio types.');

        $this->episodeNumber = $episodeNumber;
        $this->title = $title;
        $this->sources = $sources;
        $this->metadata = [
            'number' => $episodeNumber,
            'chapters' => [],
        ];
        foreach ($chapters as $chapter) {
            $this->metadata['chapters'][] = [
                'number' => $chapter['chapterNumber'],
                'title' => $chapter['title'],
                'time' => $chapter['startTime']['forMachine'],
            ];
        }
        $this->metadata = str_replace('"', '\'', json_encode($this->metadata));
    }

    public function addSource(MediaSource $source)
    {
        $this->sources[] = $source;
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

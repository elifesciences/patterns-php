<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class MediaChapterListingItem implements ViewModel
{
    use ArrayFromProperties;
    use ComposedAssets;
    use ReadOnlyArrayAccess;

    private $title;
    private $startTime;
    private $chapterNumber;
    private $content;
    private $meta;

    public function __construct(
        string $title,
        int $startTime,
        int $chapterNumber,
        string $content = null,
        Meta $meta = null
    ) {
        Assertion::minLength($title, 1);
        Assertion::min($startTime, 0);
        Assertion::min($chapterNumber, 1);

        $this->title = $title;

        if (null !== $startTime) {
            $minutes = floor($startTime / 60);
            $seconds = str_pad($startTime % 60, 2, '0', STR_PAD_LEFT);
            $this->startTime = [
                'forMachine' => $startTime,
                'forHuman' => sprintf('%s:%s', $minutes, $seconds),
            ];
        }

        $this->chapterNumber = $chapterNumber;
        $this->content = $content;
        $this->meta = $meta;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/media-chapter-listing-item.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/media-chapter-listing-item.css';
        yield '/elife/patterns/assets/css/teaser.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->meta;
    }
}

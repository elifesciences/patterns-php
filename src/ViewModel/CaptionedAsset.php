<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;
use Traversable;

final class CaptionedAsset implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $heading;
    private $captions;
    private $picture;
    private $customContent;
    private $video;
    private $tables;
    private $image;
    private $doi;
    private $download;

    private function __construct(
        IsCaptioned $figure,
        string $heading = null,
        array $captions = null,
        string $customContent = null,
        Doi $doi = null,
        Link $download = null
    ) {
        $this->heading = $heading;
        $this->captions = $captions;
        $this->customContent = $customContent;
        $this->setFigure($figure);
        if ($doi !== null) {
            $doi = FlexibleViewModel::fromViewModel($doi);
            $this->doi = $doi->withProperty('variant', Doi::ASSET);
        }
        if ($download) {
            $this->download = [
                'link' => $download['url'],
                'filename' => $download['name'],
            ];
        }
    }

    private function setFigure($figure)
    {
        // Reverse switch (i.e. which evaluates to true)
        switch (true) {
            case $figure instanceof Image:
                $this->image = $figure;
                break;

            case $figure instanceof Picture:
                $this->picture = $figure;
                break;

            case $figure instanceof Video:
                $this->video = $figure;
                break;

            case $figure instanceof Table:
                $this->tables = $figure['tables'];
                break;

            default:
                throw new InvalidArgumentException('Unknown figure type '.get_class($figure));
        }
    }

    public static function withOnlyHeading(
        IsCaptioned $image,
        string $heading,
        Doi $doi = null,
        Link $download = null
    ) : CaptionedAsset {
        Assertion::notBlank($heading);

        return new static($image, $heading, null, null, $doi, $download);
    }

    public static function withParagraph(
        IsCaptioned $image,
        string $heading,
        string $caption,
        Doi $doi = null,
        Link $download = null
    ) : CaptionedAsset {
        Assertion::notBlank($heading);
        Assertion::notBlank($caption);

        return new static($image, $heading, [['caption' => $caption]], null, $doi, $download);
    }

    public static function withParagraphs(
        IsCaptioned $image,
        string $heading,
        array $captions,
        Doi $doi = null,
        Link $download = null
    ) : CaptionedAsset {
        Assertion::notBlank($heading);
        Assertion::notBlank($captions);
        Assertion::allString($captions);

        $captions = array_map(function ($caption) {
            return ['caption' => $caption];
        }, $captions);

        return new static($image, $heading, $captions, null, $doi, $download);
    }

    public static function withCustomContent(
        IsCaptioned $image,
        string $content,
        Doi $doi = null,
        Link $download = null
    ) : CaptionedAsset {
        Assertion::notBlank($content);

        return new static($image, null, null, $content, $doi, $download);
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/captioned-asset.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/captioned-asset.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->picture;
        yield $this->doi;
    }
}

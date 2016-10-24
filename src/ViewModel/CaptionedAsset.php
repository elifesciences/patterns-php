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

    private function __construct(
        IsCaptioned $figure,
        string $heading = null,
        array $captions = null,
        string $customContent = null
    ) {
        $this->heading = $heading;
        $this->captions = $captions;
        $this->customContent = $customContent;
        $this->setFigure($figure);
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

    public static function withOnlyHeading(IsCaptioned $image, string $heading) : CaptionedAsset
    {
        Assertion::notBlank($heading);

        return new static($image, $heading);
    }

    public static function withParagraph(IsCaptioned $image, string $heading, string $caption) : CaptionedAsset
    {
        Assertion::notBlank($heading);
        Assertion::notBlank($caption);

        return new static($image, $heading, [['caption' => $caption]]);
    }

    public static function withParagraphs(IsCaptioned $image, string $heading, array $captions) : CaptionedAsset
    {
        Assertion::notBlank($heading);
        Assertion::notBlank($captions);
        Assertion::allString($captions);

        $captions = array_map(function ($caption) {
            return ['caption' => $caption];
        }, $captions);

        return new static($image, $heading, $captions);
    }

    public static function withCustomContent(IsCaptioned $image, string $content) : CaptionedAsset
    {
        Assertion::notBlank($content);

        return new static($image, null, null, $content);
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
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class CaptionedImage implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $heading;
    private $captions;
    private $picture;
    private $customContent;

    private function __construct(
        Picture $picture,
        string $heading = null,
        array $captions = null,
        string $customContent = null
    ) {
        $this->heading = $heading;
        $this->captions = $captions;
        $this->picture = $picture;
        $this->customContent = $customContent;
    }

    public static function withParagraph(Picture $picture, string $heading, string $caption) : CaptionedImage
    {
        Assertion::notBlank($heading);
        Assertion::notBlank($caption);

        return new static($picture, $heading, [['caption' => $caption]]);
    }

    public static function withParagraphs(Picture $picture, string $heading, array $captions) : CaptionedImage
    {
        Assertion::notBlank($heading);
        Assertion::notBlank($captions);
        Assertion::allString($captions);

        $captions = array_map(function ($caption) {
            return ['caption' => $caption];
        }, $captions);

        return new static($picture, $heading, $captions);
    }

    public static function withCustomContent(Picture $picture, string $content) : CaptionedImage
    {
        Assertion::notBlank($content);

        return new static($picture, null, null, $content);
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/captioned-image.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/captioned-image.mustache';
    }
}

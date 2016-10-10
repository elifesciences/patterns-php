<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;
use Traversable;

final class CaptionedFigure implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $heading;
    private $captions;
    private $picture;
    private $altText;
    private $defaultPath;
    private $srcset;
    private $customContent;

    private $_image;

    private function __construct(
        IsImage $image,
        string $heading = null,
        array $captions = null,
        string $customContent = null
    ) {
        $this->heading = $heading;
        $this->captions = $captions;
        if ($image instanceof Image) {
            $this->altText = $image['altText'];
            $this->defaultPath = $image['defaultPath'];
            $this->srcset = $image['srcset'];
            $this->_image = $image;
        } elseif ($image instanceof Picture) {
            $this->picture = $image;
        } else {
            throw new InvalidArgumentException('Unknown image type '.get_class($image));
        }
        $this->customContent = $customContent;
    }

    public static function withOnlyHeading(IsImage $image, string $heading) : CaptionedImage
    {
        Assertion::notBlank($heading);

        return new static($image, $heading);
    }

    public static function withParagraph(IsImage $image, string $heading, string $caption) : CaptionedImage
    {
        Assertion::notBlank($heading);
        Assertion::notBlank($caption);

        return new static($image, $heading, [['caption' => $caption]]);
    }

    public static function withParagraphs(IsImage $image, string $heading, array $captions) : CaptionedImage
    {
        Assertion::notBlank($heading);
        Assertion::notBlank($captions);
        Assertion::allString($captions);

        $captions = array_map(function ($caption) {
            return ['caption' => $caption];
        }, $captions);

        return new static($image, $heading, $captions);
    }

    public static function withCustomContent(IsImage $image, string $content) : CaptionedImage
    {
        Assertion::notBlank($content);

        return new static($image, null, null, $content);
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/captioned-image.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/captioned-image.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->picture;
    }
}

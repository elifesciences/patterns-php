<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ViewerInline implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $id;
    private $prominentText;
    private $normalText;
    private $seeAllLink;
    private $downloadLink;
    private $newWindowLink;
    private $captionedImage;

    public function __construct(
        string $id,
        string $prominentText,
        string $normalText,
        string $seeAllLink,
        string $downloadLink,
        string $newWindowLink,
        CaptionedImage $captionedImage
    ) {
        Assertion::notBlank($id);
        Assertion::notBlank($prominentText);
        Assertion::notBlank($normalText);
        Assertion::notBlank($seeAllLink);
        Assertion::notBlank($downloadLink);
        Assertion::notBlank($newWindowLink);

        $this->id = $id;
        $this->prominentText = $prominentText;
        $this->normalText = $normalText;
        $this->seeAllLink = $seeAllLink;
        $this->downloadLink = $downloadLink;
        $this->newWindowLink = $newWindowLink;
        $this->captionedImage = $captionedImage;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/viewer-inline.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/viewer-inline.mustache';
    }
}

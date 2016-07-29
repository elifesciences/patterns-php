<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Teaser implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $title;
    private $rootClasses;
    private $url;
    private $content;
    private $secondaryInfo;
    private $contextLabel;
    private $eventDate;
    private $category;
    private $image;
    private $footer;

    protected function __construct(
        string $title,
        string $rootClasses = null,
        string $url = null,
        string $content = null,
        string $secondaryInfo = null,
        SiteLinks $contextLabel = null,
        Date $eventDate = null,
        Link $category = null,
        TeaserImage $image = null,
        TeaserFooter $footer = null
    ) {
        Assertion::notBlank($title);

        $this->title = $title;
        $this->rootClasses = $rootClasses;
        $this->url = $url;
        $this->content = $content;
        $this->secondaryInfo = $secondaryInfo;
        $this->contextLabel = $contextLabel;
        $this->eventDate = $eventDate;
        $this->category = $category;
        $this->image = $image;
        $this->footer = $footer;
    }

    public static function basic($title)
    {
        return new static($title);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/teaser.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/teaser.css';
    }
}

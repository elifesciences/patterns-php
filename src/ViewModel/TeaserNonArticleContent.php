<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class TeaserNonArticleContent implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $content;
    private $date;
    private $headerText;
    private $link;

    public function __construct(string $content, Date $date, string $headerText, string $link, string $subHeader = null,
                                string $footerText = null, string $downloadSrc = null)
    {
        Assertion::notBlank($content);
        Assertion::notBlank($headerText);
        Assertion::notBlank($link);

        Assertion::nullOrNotBlank($subHeader);
        Assertion::nullOrNotBlank($footerText);
        Assertion::nullOrNotBlank($downloadSrc);

        $this->content = $content;
        $this->date = $date;
        $this->headerText = $headerText;
        $this->link = $link;
        $this->subHeader = $subHeader;
        $this->footerText = $footerText;
        $this->downloadSrc = $downloadSrc;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/teaser--non-article-content.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/teaser--non-article-content.mustache';
    }
}

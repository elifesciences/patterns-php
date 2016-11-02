<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Doi implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    const ARTICLE_SECTION = 'article-section';
    const ASSET = 'asset';

    private $doi;
    private $variant;
    private $isTruncated;

    public function __construct(string $doi, string $variant = null, bool $isTruncated = false)
    {
        Assertion::regex($doi, '~^10[.][0-9]{4,}[^\s"/<>]*/[^\s"]+$~');
        if ($variant !== null) {
            Assertion::inArray($variant, [self::ARTICLE_SECTION, self::ASSET]);
        }

        $this->variant = $variant;
        $this->doi = $doi;
        $this->isTruncated = $isTruncated;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/doi.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/doi.css';
    }
}

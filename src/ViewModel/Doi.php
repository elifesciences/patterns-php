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

    public function __construct(string $doi)
    {
        Assertion::regex($doi, '~^10[.][0-9]{4,}[^\s"/<>]*/[^\s"]+$~');
        $this->doi = $doi;
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

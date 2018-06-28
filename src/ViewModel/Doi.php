<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class Doi implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

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
        return 'resources/templates/doi.mustache';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ContextualData implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $views;
    private $comments;
    private $cited;
    private $doi;
    private $cite_as;

    const STYLE_DOI = 'contextual-data__doi';

    public function __construct(string $citeAs, int $views, int $comments, int $cited, Doi $doi)
    {
        Assertion::notBlank($citeAs);

        $this->cite_as = $citeAs;
        $this->views = $views;
        $this->comments = $comments;
        $this->cited = $cited;
        $this->doi = $this->addDoiClass($doi);
    }

    private function addDoiClass(Doi $doi)
    {
        $classNames = $doi['classNames'] ? explode(' ', $doi['classNames']) : [];
        array_push($classNames, self::STYLE_DOI);

        return new Doi($doi['uri'], $classNames);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/contextual-data.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/contextual-data.css';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ArticleDownloadLinksList implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $dlLinkArticle;
    private $dlLinkFigure;
    private $dlLinkCitsBibtex;
    private $dlLinkCitsEndnote;
    private $dlLinkCitsEndnote8;
    private $dlLinkCitsRefworks;
    private $dlLinkCitsRIS;
    private $dlLinkCitsMedlars;
    private $linkCitsMendeley;
    private $linkCitsReadCube;
    private $linkCitsPapers;
    private $linkCitsCiteULike;

    public function __construct(
        string $dlLinkArticle,
        string $dlLinkFigure,
        string $dlLinkCitsBibtex,
        string $dlLinkCitsEndnote,
        string $dlLinkCitsEndnote8,
        string $dlLinkCitsRefworks,
        string $dlLinkCitsRIS,
        string $dlLinkCitsMedlars,
        string $linkCitsMendeley,
        string $linkCitsReadCube,
        string $linkCitsPapers,
        string $linkCitsCiteULike
    ) {
        Assertion::notBlank($dlLinkArticle);
        Assertion::notBlank($dlLinkFigure);
        Assertion::notBlank($dlLinkCitsBibtex);
        Assertion::notBlank($dlLinkCitsEndnote);
        Assertion::notBlank($dlLinkCitsEndnote8);
        Assertion::notBlank($dlLinkCitsRefworks);
        Assertion::notBlank($dlLinkCitsRIS);
        Assertion::notBlank($dlLinkCitsMedlars);
        Assertion::notBlank($linkCitsMendeley);
        Assertion::notBlank($linkCitsReadCube);
        Assertion::notBlank($linkCitsPapers);
        Assertion::notBlank($linkCitsCiteULike);

        $this->dlLinkArticle = $dlLinkArticle;
        $this->dlLinkFigure = $dlLinkFigure;
        $this->dlLinkCitsBibtex = $dlLinkCitsBibtex;
        $this->dlLinkCitsEndnote = $dlLinkCitsEndnote;
        $this->dlLinkCitsEndnote8 = $dlLinkCitsEndnote8;
        $this->dlLinkCitsRefworks = $dlLinkCitsRefworks;
        $this->dlLinkCitsRIS = $dlLinkCitsRIS;
        $this->dlLinkCitsMedlars = $dlLinkCitsMedlars;
        $this->linkCitsMendeley = $linkCitsMendeley;
        $this->linkCitsReadCube = $linkCitsReadCube;
        $this->linkCitsPapers = $linkCitsPapers;
        $this->linkCitsCiteULike = $linkCitsCiteULike;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/article-download-links-list.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/article-download-links-list.css';
    }
}

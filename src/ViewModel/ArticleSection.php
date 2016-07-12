<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class ArticleSection implements ViewModel
{

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $id;
    private $title;
    private $downloadLinks;
    private $body;

    public function __construct(
      string $id,
      string $title,
      array $content,
      ArticleDownloadLinksList $downloadLinks
    ) {
        Assertion::notBlank($id);
        Assertion::notBlank($title);
        Assertion::notEmpty($content);

        $this->id = $id;
        $this->title = $title;
        $this->downloadLinks = $downloadLinks;
        $this->body = array_map(function($item) {
            return [ 'content' => $item ];
        }, $content);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/article-section.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/article-section.css';
//        yield $this->downloadLinks->getStyleSheets();
    }
}

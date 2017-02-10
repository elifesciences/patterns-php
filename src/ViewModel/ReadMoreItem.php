<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\HasAssets;
use Traversable;

final class ReadMoreItem implements CastsToArray, HasAssets
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $article;
    private $content;

    public function __construct(
        ContentHeaderArticle $article,
        string $content = null
    ) {
        $this->article = $article;
        $this->content = $content;
    }

    public function getStyleSheets() : Traversable
    {
        yield from $this->article->getStyleSheets();
    }

    public function getJavaScripts() : Traversable
    {
        yield from $this->article->getJavaScripts();
    }
}

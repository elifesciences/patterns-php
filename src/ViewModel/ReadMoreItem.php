<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class ReadMoreItem implements CastsToArray
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

    public function getStyleSheets()
    {
        yield from $this->article->getStyleSheets();
    }

    public function getJavaScripts()
    {
        yield from $this->article->getJavaScripts();
    }
}

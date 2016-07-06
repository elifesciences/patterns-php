<?php

namespace eLife\Patterns\ViewModel;

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

    public function __construct(
      string $id,
      string $title,
      array $paras
    ) {

    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/article-section.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/article-section.css';
    }
}

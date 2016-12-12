<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use Traversable;

final class LoadMore implements PaginationControl
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $name;
    private $url;

    public function __construct(Link $link)
    {
        $this->name = $link['name'];
        $this->url = $link['url'];
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/load-more.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/buttons.css';
        yield '/elife/patterns/assets/css/load-more.css';
    }
}

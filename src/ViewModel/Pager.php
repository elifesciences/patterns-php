<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use Traversable;

final class Pager implements PaginationControl
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $previousPage;
    private $nextPage;

    public function __construct(Link $previousPage = null, Link $nextPage = null)
    {
        if ($previousPage) {
            $this->previousPage = Button::link($previousPage['name'], $previousPage['url']);
        }
        if ($nextPage) {
            $this->nextPage = Button::link($nextPage['name'], $nextPage['url']);
        }
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/pager.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/pager.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->previousPage;
        yield $this->nextPage;
    }
}

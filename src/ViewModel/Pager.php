<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use Traversable;

final class Pager implements PaginationControl
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $previousPage;
    private $nextPage;

    public function __construct(Link $previousPage, Link $nextPage)
    {
        $this->previousPage = $previousPage;
        $this->nextPage = $nextPage;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/pager.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/buttons.css';
        yield '/elife/patterns/assets/css/pager.css';
    }
}

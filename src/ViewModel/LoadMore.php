<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ComposedViewModel;
use eLife\Patterns\ViewModel;
use Traversable;

final class LoadMore implements PaginationControl
{
    use ComposedViewModel;

    private $button;

    public function __construct(Link $link)
    {
        $this->button = Button::link($link['name'], $link['url'], Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, true, true);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/load-more.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/load-more.css';
    }

    protected function getViewModel() : ViewModel
    {
        return $this->button;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ReadMoreItem implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $item;
    private $content;

    public function __construct(
        ContentHeaderReadMore $item,
        string $content = null
    ) {
        $this->item = $item;
        $this->content = $content;
    }

    public function getStyleSheets() : Traversable
    {
        yield from $this->item->getStyleSheets();
    }

    public function getJavaScripts() : Traversable
    {
        yield from $this->item->getJavaScripts();
    }

    protected function getComposedViewModels(): Traversable
    {
        yield $this->item;
    }

    public function getTemplateName(): string
    {
        return '/elife/patterns/templates/read-more-item.mustache';
    }
}

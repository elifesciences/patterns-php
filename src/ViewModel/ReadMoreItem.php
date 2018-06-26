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
    private $isRelated;

    public function __construct(
        ContentHeaderReadMore $item,
        string $content = null,
        bool $isRelated = false
    ) {
        $this->item = $item;
        $this->content = $content;
        $this->isRelated = $isRelated;
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->item;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/read-more-item.mustache';
    }
}

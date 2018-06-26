<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class BlockLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $text;
    private $url;
    private $image;

    public function __construct(Link $link, Picture $image = null)
    {
        $this->text = $link['name'];
        $this->url = $link['url'];
        $this->image = $image;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/block-link.mustache';
    }
}

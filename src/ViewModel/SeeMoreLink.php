<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class SeeMoreLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    protected $name;

    protected $url;

    public function __construct(Link $link, bool $isInline = false)
    {
        $this->name = $link['name'];
        $this->url = $link['url'];
        $this->isInline = $isInline;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/see-more-link.mustache';
    }
}

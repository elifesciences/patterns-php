<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class SeeMoreLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    protected $name;

    protected $url;

    public function __construct(Link $link, bool $isInline = false, string $ariaLabel = null)
    {
        $this->name = $link['name'];
        $this->url = $link['url'];
        $this->isInline = $isInline;
        $this->ariaLabel = $ariaLabel;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/see-more-link.mustache';
    }
}

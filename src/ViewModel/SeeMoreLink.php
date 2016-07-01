<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class SeeMoreLink implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    protected $name;

    protected $url;

    public function __construct(Link $link)
    {
        $this->name = $link['name'];
        $this->url = $link['url'];
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/see-more-link.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/see-more-link.mustache';
    }
}

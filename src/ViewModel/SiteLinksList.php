<?php

namespace eLife\Patterns\ViewModel;


use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class SiteLinksList implements ViewModel
{

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $lists;

    public function __construct(array $lists)
    {
        Assertion::notEmpty($lists);
        Assertion::allIsInstanceOf($lists, SiteLinks::class);

        $this->lists = $lists;
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/site-links-list.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/site-links-list.mustache';
    }
}

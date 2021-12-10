<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class SiteHeader implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $logo;
    private $primaryLinks;
    private $secondaryLinks;
    private $searchBox;

    public function __construct(SiteHeaderLogo $logo, SiteHeaderNavBar $primaryLinks, SiteHeaderNavBar $secondaryLinks, SearchBox $searchBox = null)
    {
        $this->logo = $logo;
        $this->primaryLinks = $primaryLinks;
        $this->secondaryLinks = $secondaryLinks;
        if ($searchBox) {
            $this->searchBox = FlexibleViewModel::fromViewModel($searchBox)->withProperty('inContentHeader', true);
        }
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/site-header.mustache';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class HeroBanner implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $heroBannerItem;

    public function __construct(HeroBannerItem $heroBannerItem)
    {
        $this->heroBannerItem = $heroBannerItem;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/hero-banner-item.mustache';
    }
}

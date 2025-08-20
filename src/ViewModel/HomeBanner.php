<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class HomeBanner implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    public function getTemplateName() : string
    {
        return 'resources/templates/home-banner.mustache';
    }
}

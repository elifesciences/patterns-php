<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class TestimonialWithLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    public function __construct() {
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/testimonial-with-link.mustache';
    }
}

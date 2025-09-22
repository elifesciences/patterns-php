<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class TestimonialWithLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $quotation;
    private $attribution;
    private $link;

    public function __construct(string $quotation, string $attribution, Link $link) {
        $this->quotation = $quotation;
        $this->attribution = $attribution;
        $this->link = $link;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/testimonial-with-link.mustache';
    }
}

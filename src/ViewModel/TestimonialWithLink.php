<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;
use function eLife\Patterns\last_word_indicator;

final class TestimonialWithLink implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $quotation;
    private $quotationLastWord;
    private $attribution;
    private $link;

    public function __construct(string $quotation, string $attribution, Link $link) {
        $this->setQuotation($quotation);
        $this->attribution = $attribution;
        $this->link = $link;
    }

    private function setQuotation(string $quotation) : void
    {
        $words = explode(' ', trim($quotation));
        $lastWord = array_pop($words);
        
        if (count($words) > 0) {
            $this->quotation = implode(' ', $words).' ';
            $this->quotationLastWord = $lastWord;
        } else {
            $this->quotation = $lastWord;
        }
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/testimonial-with-link.mustache';
    }
}

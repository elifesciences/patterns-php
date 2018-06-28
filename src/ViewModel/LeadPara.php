<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class LeadPara implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    protected $text;

    public function __construct(string $text, string $id = null)
    {
        Assertion::notBlank($text);

        $this->text = $text;
        $this->id = $id;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/lead-para.mustache';
    }
}

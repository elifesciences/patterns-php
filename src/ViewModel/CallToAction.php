<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class CallToAction implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $button;
    private $image;
    private $text;

    public function __construct(Picture $image, string $text, Button $button)
    {
        Assertion::notBlank($text);

        $this->image = $image;
        $this->text = $text;
        $this->button = $button;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/call-to-action.mustache';
    }
}

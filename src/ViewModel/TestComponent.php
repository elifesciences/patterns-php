<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class TestComponent implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $name;

    public function __construct(string $name)
    {
        Assertion::notBlank($name);

        $this->name = $name;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/test-component.mustache';
    }
}

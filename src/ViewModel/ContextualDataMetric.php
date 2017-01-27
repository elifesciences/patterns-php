<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class ContextualDataMetric implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $name;
    private $value;
    private $elementId;

    public function __construct(string $name, string $value, string $elementId = null)
    {
        Assertion::notBlank($name);
        Assertion::notBlank($value);

        $this->name = $name;
        $this->value = $value;
        $this->elementId = $elementId;
    }
}

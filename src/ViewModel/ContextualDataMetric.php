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
    private $elementId;
    private $value;

    public function __construct(string $name, string $elementId, string $value)
    {
        Assertion::notBlank($name);
        Assertion::notBlank($elementId);
        Assertion::notBlank($value);

        $this->name = $name;
        $this->elementId = $elementId;
        $this->value = $value;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class Statistic implements ViewModel
{
    use ArrayFromProperties;
    use ArrayAccessFromProperties;
    use SimplifyAssets;

    private $label;
    private $value;

    public static function fromString(string $label, string $value)
    {
        return new static($label, $value);
    }

    public static function fromNumber(string $label, int $value)
    {
        return new static($label, number_format($value));
    }

    private function __construct(string $label, string $value)
    {
        Assertion::notBlank($label);
        Assertion::notBlank($value);

        $this->label = $label;
        $this->value = $value;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/statistic.mustache';
    }
}

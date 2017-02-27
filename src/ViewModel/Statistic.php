<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

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

    public function getStyleSheets(): Traversable
    {
        yield '/elife/patterns/assets/css/statistic.css';
    }

    public function getTemplateName(): string
    {
        return '/elife/patterns/templates/statistic.mustache';
    }
}

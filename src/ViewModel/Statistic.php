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
    private $modifiers;

    public static function fromString(string $label, string $value, string $modifiers = null)
    {
        return new static($label, $value, $modifiers);
    }

    public static function fromNumber(string $label, int $value, string $modifiers = null)
    {
        return new static($label, number_format($value), $modifiers);
    }

    private function __construct(string $label, string $value, string $modifiers = null)
    {
        Assertion::notBlank($label);
        Assertion::notBlank($value);

        $this->label = $label;
        $this->value = $value;
        $this->modifiers = $modifiers;
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

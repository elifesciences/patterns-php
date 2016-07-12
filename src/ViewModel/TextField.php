<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class TextField implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $inputType;
    private $label;
    private $name;

    protected function __construct(
        string $inputType,
        /* Label */ $label,
        string $name = null
    ) {
        Assertion::notBlank($inputType);
        Assertion::inArray($inputType, ['text', 'email']);

        $this->inputType = $inputType;
        $this->label = $label;
        $this->name = $name;
    }

    public static function textInput($label, $name = null)
    {
        return new static('text', $label, $name);
    }

    public static function emailInput($label, $name = null)
    {
        return new static('email', $label, $name);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/text-field.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/text-field.css';
    }
}

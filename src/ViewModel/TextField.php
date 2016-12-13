<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class TextField implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $inputType;
    private $label;
    private $name;
    private $id;
    private $placeholder;
    private $required;
    private $disabled;

    protected function __construct(
        string $inputType,
        FormLabel $label,
        string $id,
        string $name,
        bool $placeholder = null,
        bool $required = null,
        bool $disabled = null
    ) {
        Assertion::notBlank($inputType);
        Assertion::inArray($inputType, ['text', 'email']);
        Assertion::same($id, $label['for']);

        $this->inputType = $inputType;
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
    }

    public static function textInput(
        FormLabel $label,
        string $id,
        string $name,
        bool $placeholder = null,
        bool $required = null,
        bool $disabled = null
    ) {
        return new static('text', $label, $id, $name, $placeholder, $required, $disabled);
    }

    public static function emailInput(
        FormLabel $label,
        string $id,
        string $name,
        bool $placeholder = null,
        bool $required = null,
        bool $disabled = null
    ) {
        return new static('email', $label, $id, $name, $placeholder, $required, $disabled);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/text-field.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/text-fields.css';
    }
}

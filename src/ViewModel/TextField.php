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
    const STATUS_ERROR = 'error';
    const STATUS_VALID = 'valid';

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
    private $autofocus;
    private $value;
    private $classNames;

    protected function __construct(
        string $inputType,
        FormLabel $label,
        string $id,
        string $name,
        string $placeholder = null,
        bool $required = null,
        bool $disabled = null,
        bool $autofocus = null,
        string $value = null,
        string $status = null
    ) {
        Assertion::notBlank($inputType);
        Assertion::inArray($inputType, ['text', 'email']);
        Assertion::same($id, $label['for']);
        Assertion::nullOrChoice($status, [self::STATUS_ERROR, self::STATUS_VALID]);

        $this->inputType = $inputType;
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->autofocus = $autofocus;
        $this->value = $value;
        if (false === empty($status)) {
            $this->classNames = 'text-field--'.$status;
        }
    }

    public static function textInput(
        FormLabel $label,
        string $id,
        string $name,
        string $placeholder = null,
        bool $required = null,
        bool $disabled = null,
        bool $autofocus = null,
        string $value = null,
        string $status = null
    ) {
        return new static('text', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $status);
    }

    public static function emailInput(
        FormLabel $label,
        string $id,
        string $name,
        string $placeholder = null,
        bool $required = null,
        bool $disabled = null,
        bool $autofocus = null,
        string $value = null,
        string $status = null
    ) {
        return new static('email', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $status);
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

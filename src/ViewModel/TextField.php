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
    private $status;
    private $message;

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
        string $status = null,
        string $message = null
    ) {
        Assertion::notBlank($inputType);
        Assertion::inArray($inputType, ['email', 'password', 'search', 'tel', 'text', 'url']);
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
        $this->status = $status;
        $this->message = $message;
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
        string $status = null,
        string $message = null
    ) {
        return new static('email', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $status, $message);
    }

    public static function passwordInput(
        FormLabel $label,
        string $id,
        string $name,
        string $placeholder = null,
        bool $required = null,
        bool $disabled = null,
        bool $autofocus = null,
        string $value = null,
        string $status = null,
        string $message = null
    ) {
        return new static('password', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $status, $message);
    }

    public static function searchInput(
        FormLabel $label,
        string $id,
        string $name,
        string $placeholder = null,
        bool $required = null,
        bool $disabled = null,
        bool $autofocus = null,
        string $value = null,
        string $status = null,
        string $message = null
    ) {
        return new static('search', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $status, $message);
    }

    public static function telInput(
        FormLabel $label,
        string $id,
        string $name,
        string $placeholder = null,
        bool $required = null,
        bool $disabled = null,
        bool $autofocus = null,
        string $value = null,
        string $status = null,
        string $message = null
    ) {
        return new static('tel', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $status, $message);
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
        string $status = null,
        string $message = null
    ) {
        return new static('text', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $status, $message);
    }

    public static function urlInput(
        FormLabel $label,
        string $id,
        string $name,
        string $placeholder = null,
        bool $required = null,
        bool $disabled = null,
        bool $autofocus = null,
        string $value = null,
        string $status = null,
        string $message = null
    ) {
        return new static('url', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $status, $message);
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/text-field.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/text-fields.css';
        yield 'resources/assets/css/form-item.css';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;
use Traversable;

final class TextField implements ViewModel
{
    const STATE_ERROR = 'error';
    const STATE_VALID = 'valid';

    const VARIANT_ERROR = self::STATE_ERROR;
    const VARIANT_VALID = self::STATE_VALID;
    const VARIANT_INFO = 'info';

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
    private $state;
    private $message;
    private $userInputInvalid;
    private $variant;

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
        string $state = null,
        Message $message = null
    ) {
        Assertion::notBlank($inputType);
        Assertion::inArray($inputType, ['email', 'password', 'search', 'tel', 'text', 'url']);
        Assertion::nullOrChoice($state, [self::STATE_ERROR, self::STATE_VALID]);

        if ($state === self::STATE_ERROR) {
            if (!$message) {
                throw new InvalidArgumentException('There must be a message if the state is error.');
            }
            $this->userInputInvalid = true;
        }
        $this->inputType = $inputType;
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->autofocus = $autofocus;
        $this->value = $value;
        $this->state = $state;
        $this->message = $message;
        $this->variant = null;
        if ($this->state === self::STATE_ERROR) {
            $this->variant = self::VARIANT_ERROR;
        } elseif ($this->state === self::STATE_VALID) {
            $this->variant = self::VARIANT_VALID;
        } elseif ($message) {
            $this->variant = self::VARIANT_INFO;
        }
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
        string $state = null,
        Message $message = null
    ) {
        return new static('email', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message);
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
        string $state = null,
        Message $message = null
    ) {
        return new static('password', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message);
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
        string $state = null,
        Message $message = null
    ) {
        return new static('search', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message);
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
        string $state = null,
        Message $message = null
    ) {
        return new static('tel', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message);
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
        string $state = null,
        Message $message = null
    ) {
        return new static('text', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message);
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
        string $state = null,
        Message $message = null
    ) {
        return new static('url', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message);
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

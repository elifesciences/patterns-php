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
    private $messageId;

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
        string $message = null,
        string $messageId = null
    ) {
        Assertion::notBlank($inputType);
        Assertion::inArray($inputType, ['email', 'password', 'search', 'tel', 'text', 'url']);
        Assertion::nullOrChoice($state, [self::STATE_ERROR, self::STATE_VALID]);

        if ($state === self::STATE_VALID && $messageId) {
            throw new InvalidArgumentException('There must not be a messageId if the state is valid.');
        }

        if ($state === self::STATE_ERROR) {
            if (!$messageId) {
                throw new InvalidArgumentException('There must be a messageId if the state is error.');
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
        $this->messageId = $messageId;
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
        string $message = null,
        string $messageId = null
    ) {
        return new static('email', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message, $messageId);
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
        string $message = null,
        string $messageId = null
    ) {
        return new static('password', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message, $messageId);
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
        string $message = null,
        string $messageId = null
    ) {
        return new static('search', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message, $messageId);
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
        string $message = null,
        string $messageId = null
    ) {
        return new static('tel', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message, $messageId);
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
        string $message = null,
        string $messageId = null
    ) {
        return new static('text', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message, $messageId);
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
        string $message = null,
        string $messageId = null
    ) {
        return new static('url', $label, $id, $name, $placeholder, $required, $disabled, $autofocus, $value, $state, $message, $messageId);
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

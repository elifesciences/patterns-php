<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use InvalidArgumentException;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class TextArea implements ViewModel
{
    const STATE_ERROR = 'error';
    const STATE_VALID = 'valid';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $label;
    private $name;
    private $id;
    private $value;
    private $placeholder;
    private $required;
    private $disabled;
    private $autofocus;
    private $cols;
    private $rows;
    private $form;
    private $state;
    private $message;
    private $userInputInvalid;
    private $messageId;

    public function __construct(
        FormLabel $label,
        string $id,
        string $name,
        string $value = null,
        string $placeholder = null,
        bool $required = null,
        bool $disabled = null,
        bool $autofocus = null,
        int $cols = null,
        int $rows = null,
        string $form = null,
        string $state = null,
        string $message = null,
        string $messageId = null
    ) {
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
        $this->label = $label;
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->autofocus = $autofocus;
        $this->cols = $cols;
        $this->rows = $rows;
        $this->form = $form;
        $this->state = $state;
        $this->message = $message;
        $this->messageId = $messageId;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/text-area.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/text-fields.css';
        yield 'resources/assets/css/form-item.css';
    }
}

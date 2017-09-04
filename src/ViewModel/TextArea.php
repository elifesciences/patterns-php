<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;
use Traversable;

final class TextArea implements ViewModel
{
    const STATE_ERROR = 'error';
    const STATE_VALID = 'valid';

    const VARIANT_ERROR = TextField::STATE_ERROR;
    const VARIANT_VALID = TextField::STATE_VALID;
    const VARIANT_INFO = 'info';

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
    private $variant;

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
        Message $message = null
    ) {
        Assertion::nullOrChoice($state, [self::STATE_ERROR, self::STATE_VALID]);

        if ($state === self::STATE_ERROR) {
            if (!$message) {
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
        $this->variant = null;
        $this->variant = null;
        if ($this->state === TextField::STATE_ERROR) {
            $this->variant = TextField::VARIANT_ERROR;
        } elseif ($this->state === TextField::STATE_VALID) {
            $this->variant = TextField::VARIANT_VALID;
        } elseif ($message) {
            $this->variant = self::VARIANT_INFO;
        }
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

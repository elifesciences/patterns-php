<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class TextArea implements ViewModel
{
    const STATUS_ERROR = 'error';
    const STATUS_VALID = 'valid';

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
    private $classNames;

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
        string $status = null
    ) {
        Assertion::same($id, $label['for']);
        Assertion::nullOrChoice($status, [self::STATUS_ERROR, self::STATUS_VALID]);

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
        if (false === empty($status)) {
            $this->classNames = 'text-field--'.$status;
        }
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/text-area.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/text-fields.css';
    }
}

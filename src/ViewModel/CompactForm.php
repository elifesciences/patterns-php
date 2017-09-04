<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use InvalidArgumentException;
use Traversable;

final class CompactForm implements ViewModel
{
    const STATE_ERROR = 'error';
    const STATE_VALID = 'valid';

    const VARIANT_ERROR = TextField::STATE_ERROR;
    const VARIANT_VALID = TextField::STATE_VALID;
    const VARIANT_INFO = 'info';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $formAction;
    private $formId;
    private $formMethod;
    private $label;
    private $inputType;
    private $inputName;
    private $inputValue;
    private $inputPlaceholder;
    private $inputAutofocus;
    private $ctaText;
    private $state;
    private $message;
    private $hiddenFields;
    private $honeypot;
    private $userInputInvalid;
    private $variant;

    public function __construct(Form $form, Input $input, string $ctaText, string $state = null, Message $message = null, array $hiddenFields = [], Honeypot $honeypot = null)
    {
        Assertion::notBlank($ctaText);
        Assertion::allIsInstanceOf($hiddenFields, HiddenField::class);

        if ($state === self::STATE_ERROR) {
            if (!$message) {
                throw new InvalidArgumentException('There must be a message if the state is error.');
            }
            $this->userInputInvalid = true;
        }
        $this->formAction = $form['action'];
        $this->formId = $form['id'];
        $this->formMethod = $form['method'];
        $this->label = $input['label'];
        $this->inputType = $input['type'];
        $this->inputName = $input['name'];
        $this->inputValue = $input['value'];
        $this->inputPlaceholder = $input['placeholder'];
        $this->inputAutofocus = $input['autofocus'];
        $this->ctaText = $ctaText;
        $this->state = $state;
        $this->message = $message;
        $this->hiddenFields = $hiddenFields;
        $this->honeypot = $honeypot;
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
        return 'resources/templates/compact-form.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/compact-form.css';
    }
}

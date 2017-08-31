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
    private $messageId;

    public function __construct(Form $form, Input $input, string $ctaText, string $state = null, string $message = null, array $hiddenFields = [], Honeypot $honeypot = null, string $messageId = null)
    {
        Assertion::notBlank($ctaText);
        Assertion::allIsInstanceOf($hiddenFields, HiddenField::class);

        if ($state === self::STATE_VALID && $messageId) {
            throw new InvalidArgumentException('There must not be a messageId if the state is valid.');
        }

        if ($state === self::STATE_ERROR) {
            if (!$messageId) {
                throw new InvalidArgumentException('There must be a messageId if the state is error.');
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
        $this->messageId = $messageId;
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

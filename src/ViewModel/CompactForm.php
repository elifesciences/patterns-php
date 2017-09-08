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
    const STATE_INVALID = 'invalid';
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
    private $messageGroup;
    private $hiddenFields;
    private $honeypot;
    private $isInvalid;

    public function __construct(Form $form, Input $input, string $ctaText, string $state = null, MessageGroup $messageGroup = null, array $hiddenFields = [], Honeypot $honeypot = null)
    {
        Assertion::notBlank($ctaText);
        Assertion::allIsInstanceOf($hiddenFields, HiddenField::class);

        if ($state === self::STATE_INVALID) {
            if (is_null($messageGroup) || empty($messageGroup['errorText'])) {
                throw new InvalidArgumentException('There must be a message group containing error text if the state is error.');
            }
            $this->isInvalid = true;
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
        $this->messageGroup = $messageGroup;
        $this->hiddenFields = $hiddenFields;
        $this->honeypot = $honeypot;
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

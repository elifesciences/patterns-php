<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class CompactForm implements ViewModel
{
    const STATE_INVALID = 'invalid';
    const STATE_VALID = 'valid';
    const VARIANT_INSTITUTION_ELIGIBILITY = 'institution-eligibility';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;

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
    private $visibleLabel;
    private $variant;

    public function __construct(Form $form, Input $input, string $ctaText, string $state = null, MessageGroup $messageGroup = null, array $hiddenFields = [], Honeypot $honeypot = null, bool $visibleLabel = false)
    {
        Assertion::notBlank($ctaText);
        Assertion::allIsInstanceOf($hiddenFields, HiddenField::class);

        if (self::STATE_INVALID === $state) {
            Assertion::notNull($messageGroup);
            Assertion::notBlank($messageGroup['errorText']);
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
        if ($visibleLabel) {
            $this->visibleLabel = true;
        }
    }

    public function withVisibleLabel() : self
    {
        $this->visibleLabel = true;

        return $this;
    }

    public function withVariant(string $variant) : self
    {
        Assertion::choice($variant, [
            self::VARIANT_INSTITUTION_ELIGIBILITY,
        ]);

        $this->variant = $variant;

        return $this;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/compact-form.mustache';
    }
}

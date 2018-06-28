<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class EmailCta implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $headerText;
    private $subHeader;
    private $compactForm;
    private $formFieldInfoLink;

    public function __construct(
        string $headerText,
        string $subHeader,
        CompactForm $compactForm,
        FormFieldInfoLink $formFieldInfoLink = null
    ) {
        Assertion::notBlank($headerText);
        Assertion::notBlank($subHeader);

        if ($formFieldInfoLink) {
            $formFieldInfoLink = FlexibleViewModel::fromViewModel($formFieldInfoLink)->withProperty('alignLeft', true);
        }

        $this->headerText = $headerText;
        $this->subHeader = $subHeader;
        $this->compactForm = $compactForm;
        $this->formFieldInfoLink = $formFieldInfoLink;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/email-cta.mustache';
    }
}

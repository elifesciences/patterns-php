<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class EmailCta implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

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

        $this->headerText = $headerText;
        $this->subHeader = $subHeader;
        $this->compactForm = $compactForm;
        $this->formFieldInfoLink = $formFieldInfoLink;
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield 'resources/assets/css/email-cta.css';
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/email-cta.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->compactForm;
        yield $this->formFieldInfoLink;
    }
}

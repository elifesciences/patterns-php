<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class EmailCta implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    protected $headerText;
    protected $subHeader;
    protected $compactForm;

    public function __construct(
        string $headerText,
        string $subHeader,
        CompactForm $compactForm
    ) {
        Assertion::notBlank($headerText);
        Assertion::notBlank($subHeader);

        $this->headerText = $headerText;
        $this->subHeader = $subHeader;
        $this->compactForm = $compactForm;
    }

    public function getStyleSheets() : Traversable
    {
        yield $this->compactForm->getStyleSheets();
        yield '/elife/patterns/assets/css/email-cta.css';
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/email-cta.mustache';
    }
}

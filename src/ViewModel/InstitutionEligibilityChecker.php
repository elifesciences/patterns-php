<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class InstitutionEligibilityChecker implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $label;
    private $inputValue;
    private $inputPlaceholder;
    private $ctaText;
    private $searchUrl;

    public function __construct(
        string $label,
        string $inputPlaceholder,
        string $ctaText,
        string $searchUrl,
        string $inputValue = ''
    ) {
        Assertion::notBlank($label);
        Assertion::notBlank($inputPlaceholder);
        Assertion::notBlank($ctaText);
        Assertion::notBlank($searchUrl);

        $this->label = $label;
        $this->inputValue = $inputValue;
        $this->inputPlaceholder = $inputPlaceholder;
        $this->ctaText = $ctaText;
        $this->searchUrl = $searchUrl;
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/institution-eligibility-checker.mustache';
    }
}
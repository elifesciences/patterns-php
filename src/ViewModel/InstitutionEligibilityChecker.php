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
    private $inputName;
    private $inputPlaceholder;
    private $ctaText;
    private $searchUrl;

    public function __construct(
        string $label,
        string $inputPlaceholder,
        string $ctaText,
        string $searchUrl,
        string $inputValue = '',
        string $inputName = ''
    ) {
        Assertion::notBlank($label);
        Assertion::notBlank($inputPlaceholder);
        Assertion::notBlank($ctaText);
        Assertion::notBlank($searchUrl);
        Assertion::notBlank($inputName);

        $this->label = $label;
        $this->inputValue = $inputValue;
        $this->inputPlaceholder = $inputPlaceholder;
        $this->ctaText = $ctaText;
        $this->searchUrl = $searchUrl;
        $this->inputName = $inputName;
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/institution-eligibility-checker.mustache';
    }
}
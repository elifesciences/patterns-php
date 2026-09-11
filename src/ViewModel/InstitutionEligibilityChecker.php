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

    private $searchResults;
    private $outcome;
    private $compactForm;
    private $institutionsUrl;

    public function __construct(
        CompactForm                   $compactForm = null,
        InstitutionSearchResults      $searchResults = null,
        InstitutionEligibilityOutcome $outcome = null,
        string                        $institutionsUrl = ''
    ) {
        if ($compactForm !== null) {
            Assertion::notBlank($compactForm->getFormAction());
        }

        $this->searchResults = $searchResults;
        $this->outcome = $outcome;
        $this->compactForm = $compactForm;
        $this->institutionsUrl = $institutionsUrl;
    }

    public function getTemplateName(): string
    {
        return 'resources/templates/eligibility-tool-checker.mustache';
    }
}
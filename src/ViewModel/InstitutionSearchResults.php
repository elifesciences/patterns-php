<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class InstitutionSearchResults implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $searchResults;
    private $emptyMessage;

    public function __construct(array $searchResults, string $emptyMessage = null)
    {
        Assertion::allIsInstanceOf($searchResults, Link::class);

        $this->searchResults = $searchResults;
        $this->emptyMessage = $emptyMessage;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/eligibility-tool-institution-search-results.mustache';
    }
}

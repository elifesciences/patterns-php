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

    private $institutions;
    private $emptyMessage;

    public function __construct(array $institutions, string $emptyMessage = null)
    {
        Assertion::allIsInstanceOf($institutions, Link::class);

        $this->institutions = $institutions;
        $this->emptyMessage = $emptyMessage;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/institution-search-results.mustache';
    }
}

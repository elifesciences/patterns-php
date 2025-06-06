<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class Altmetric implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $doi;

    public function __construct(
        string $doi
    ) {
        Assertion::notBlank($doi);
        $this->doi = $doi;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/altmetric.mustache';
    }
}

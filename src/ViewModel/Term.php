<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class Term implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $term;
    private $isHighlighted;

    public function __construct(string $term, bool $isHighlighted = null)
    {
        Assertion::notBlank($term);
        Assertion::nullOrTrue($isHighlighted);

        $this->term = $term;
        $this->isHighlighted = null;
        if (isset($isHighlighted) && $isHighlighted) {
            $this->isHighlighted = $isHighlighted;
        }
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/term.mustache';
    }
}

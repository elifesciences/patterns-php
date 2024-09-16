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

    private $title;
    private $description;
    private $terms;

    public function __construct(string $title, string $description, array $terms)
    {
        Assertion::notBlank($title);
        Assertion::notBlank($description);
        Assertion::notEmpty($terms);
        Assertion::allNotEmpty($terms);

        $this->title = $title;
        $this->description = $description;

        $this->terms = array_map(function (string $term, bool $isHighlighted) {
            return [
                'term' => $term,
                'isHighlighted' => $isHighlighted,
            ];
        }, array_keys($terms), array_values($terms));
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/term.mustache';
    }
}
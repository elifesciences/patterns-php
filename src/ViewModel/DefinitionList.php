<?php

namespace eLife\Patterns\ViewModel;

use function array_values;
use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class DefinitionList implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $items;
    private $variant;

    public function __construct(array $items, string $variant = null)
    {
        Assertion::notEmpty($items);
        Assertion::allNotEmpty($items);

        $this->items = array_map(function (string $term, $descriptors) {
            $descriptors = (array) $descriptors;

            Assertion::allString($descriptors);

            return [
                'term' => $term,
                'descriptors' => $descriptors,
            ];
        }, array_keys($items), array_values($items));

        if ($variant) {
            $this->variant = $variant;
        }
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/definition-list.mustache';
    }
}

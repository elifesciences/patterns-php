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

    private function __construct(array $items, string $variant = null)
    {
        Assertion::notEmpty($items);
        Assertion::allNotEmpty($items);

        if ('timeline' === $variant) {
            $this->items = $items;
        } else {
            $this->items = array_map(function (string $term, $descriptors) {
                $descriptors = (array)$descriptors;

                Assertion::allString($descriptors);

                return [
                    'term' => $term,
                    'descriptors' => $descriptors,
                ];
            }, array_keys($items), array_values($items));
        }

        $this->variant = $variant;
    }

    public static function basic(array $items) : DefinitionList
    {
        return new self($items);
    }

    public static function inline(array $items) : DefinitionList
    {
        return new self($items, 'inline');
    }

    public static function timeline(array $items) : DefinitionList
    {
        return new self($items, 'timeline');
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/definition-list.mustache';
    }
}

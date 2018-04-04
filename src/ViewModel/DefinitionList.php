<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;
use function array_values;

final class DefinitionList implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $items;
    private $inline;

    public function __construct(array $items, bool $inline = false)
    {
        Assertion::notEmpty($items);
        Assertion::allIsArray($items);
        Assertion::allNotEmpty($items);

        $this->items = array_map(function (string $term, array $descriptors) {
            return [
                'term' => $term,
                'descriptors' => $descriptors,
            ];
        }, array_keys($items), array_values($items));
        if ($inline) {
            $this->inline = $inline;
        }
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/definition-list.css';
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/definition-list.mustache';
    }
}

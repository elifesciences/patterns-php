<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ArticleMeta implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $groups;

    public function __construct(array $groups)
    {
        Assertion::notEmpty($groups);
        Assertion::allIsArray($groups);

        $this->groups = array_values(array_map(function (string $title, array $items) {
            Assertion::notEmpty($items);
            Assertion::allIsInstanceOf($items, Link::class);

            return [
                'title' => $title,
                'items' => $items,
            ];
        }, array_keys($groups), array_values($groups)));
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/article-meta.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/article-meta.css';
    }
}

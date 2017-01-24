<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ArticleDownloadLinksList implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $id;
    private $description;
    private $groups;

    public function __construct(string $id, string $description, array $groups)
    {
        Assertion::notBlank($id);
        Assertion::notBlank($description);
        Assertion::notEmpty($groups);

        $this->id = $id;
        $this->description = $description;
        $this->groups = array_map(function (string $title, array $items) {
            Assertion::notBlank($title);
            Assertion::notEmpty($items);
            Assertion::allIsInstanceOf($items, Link::class);

            return [
                'title' => $title,
                'items' => $items,
            ];
        }, array_keys($groups), array_values($groups));
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/article-download-links-list.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/article-download-links-list.css';
    }
}

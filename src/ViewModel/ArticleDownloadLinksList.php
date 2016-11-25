<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class ArticleDownloadLinksList implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $description;
    private $groups;

    public function __construct(string $description, array $groups)
    {
        Assertion::notBlank($description);
        Assertion::notEmpty($groups);

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

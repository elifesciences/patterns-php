<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class MainMenuLink implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $title;
    private $titleId;
    private $items;

    public function __construct(string $title, array $items)
    {
        Assertion::notBlank($title);
        Assertion::notEmpty($items);
        Assertion::allIsInstanceOf($items, Link::class);

        $this->title = $title;
        $this->titleId = 'mainMenu'.hash('crc32', $title);
        $this->items = $items;
    }
}

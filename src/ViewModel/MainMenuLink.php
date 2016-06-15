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
    private $links;

    public function __construct(string $title, string $titleId, array $links)
    {
        Assertion::notBlank($title);
        Assertion::notBlank($titleId);
        Assertion::notEmpty($links);
        Assertion::allIsInstanceOf($links, Link::class);

        $this->title = $title;
        $this->titleId = $titleId;
        $this->links = $links;
    }
}

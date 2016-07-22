<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class Author implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $name;
    private $link;

    public function __construct(string $authorName, string $authorLink = null)
    {
        Assertion::notBlank($authorName);

        $this->name = $authorName;
        $this->link = $authorLink;
    }

}

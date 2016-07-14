<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class AuthorList implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $list;

    public function __construct(array $list)
    {
        Assertion::allIsInstanceOf($list, Author::class);

        $this->list = $list;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class ContextLabel implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $list;

    public function __construct(Link ...$list)
    {
        Assertion::notEmpty($list);

        $this->list = $list;
    }
}

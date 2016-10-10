<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class SubjectList implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $list;

    public function __construct(Link ...$list)
    {
        $this->list = $list;
    }
}

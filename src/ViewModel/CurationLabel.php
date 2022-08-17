<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class CurationLabel implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $list;

    public function __construct($list)
    {
        Assertion::allString($list);

        $this->list = $list;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class InstitutionList implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $list;

    public function __construct(array $list)
    {
        Assertion::allIsInstanceOf($list, Institution::class);

        $this->list = $list;
    }
}

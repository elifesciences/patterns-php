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

    public function __construct($name)
    {
        Assertion::notBlank($name);
        
        $this->name = $name;
    }
}

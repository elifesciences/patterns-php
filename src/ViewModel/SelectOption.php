<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class SelectOption implements CastsToArray
{
    use ReadOnlyArrayAccess;
    use ArrayFromProperties;

    private $value;
    private $displayValue;

    public function __construct(string $value, string $displayValue)
    {
        $this->value = $value;
        $this->displayValue = $displayValue;
    }
}

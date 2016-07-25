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
    private $selected;

    public function __construct(string $value, string $displayValue, bool $selected = false)
    {
        $this->value = $value;
        $this->displayValue = $displayValue;
        $this->selected = $selected;
    }
}

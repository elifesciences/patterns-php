<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class CheckboxesOption implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $id;
    private $value;
    private $displayValue;
    private $checked;

    public function __construct(string $id, string $value, string $displayValue, bool $checked = false)
    {
        $this->id = $id;
        $this->value = $value;
        $this->displayValue = $displayValue;
        $this->checked = $checked;
    }
}

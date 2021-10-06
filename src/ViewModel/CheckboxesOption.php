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
    private $name;
    private $value;
    private $displayValue;
    private $checked;

    public function __construct(string $id, string $name, string $value, string $displayValue, bool $checked = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->displayValue = $displayValue;
        $this->checked = $checked;
    }
}

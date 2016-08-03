<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class Filter implements CastsToArray
{
    use ReadOnlyArrayAccess;
    use ArrayFromProperties;

    private $isChecked;
    private $label;
    private $results;
    private $name;
    private $value;

    public function __construct(bool $isChecked, string $label, int $results, string $name, string $value = null)
    {
        Assertion::notBlank($label);

        $this->isChecked = $isChecked;
        $this->label = $label;
        $this->results = number_format($results);
        $this->name = $name;
        $this->value = $value;
    }
}

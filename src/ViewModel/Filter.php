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

    public function __construct(bool $isChecked, string $label, int $results)
    {
        Assertion::notBlank($label);

        $this->isChecked = $isChecked;
        $this->label = $label;
        $this->results = number_format($results);
    }
}

<?php

namespace eLife\Patterns\ViewModel;


use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

class Filter implements CastsToArray
{
    use ReadOnlyArrayAccess;
    use ArrayFromProperties;

    private $isChecked;
    private $label;
    private $results;

    public function __construct(bool $isChecked, string $label, string $results)
    {
        $this->isChecked = $isChecked;
        $this->label = $label;
        $this->results = $results;
    }

}

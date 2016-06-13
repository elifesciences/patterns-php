<?php

namespace eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

class Date implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $forHuman;
    private $forMachine;

    public function __construct(DateTimeImmutable $date)
    {
        $this->forHuman = $date->format('M j, Y');
        $this->forMachine = $date->format('Y-m-d');
    }
}

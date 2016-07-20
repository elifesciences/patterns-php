<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

class SelectNav implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $route;
    private $select;
    private $button;

    public function __construct(string $route, Select $select, Button $button)
    {
        $this->route = $route;
        $this->select = $select;
        $this->button = $button;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class SiteLinks implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $listItems;
    private $listClasses;

    public function __construct(array $listItems, string $listClasses = null)
    {
        Assertion::notEmpty($listItems);
        Assertion::allIsInstanceOf($listItems, Link::class);

        $this->listItems = $listItems;
        $this->listClasses = $listClasses;
    }
}

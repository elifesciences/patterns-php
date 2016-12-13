<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class SiteLinks implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

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

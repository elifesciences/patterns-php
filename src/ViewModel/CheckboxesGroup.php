<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class CheckboxesGroup implements CastsToArray, IsCheckboxesOption
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $children;
    private $groupLabel;

    public function __construct(array $children, string $groupLabel = null)
    {
        Assertion::notEmpty($children);
        Assertion::allIsInstanceOf($children, CheckboxesOption::class);
        Assertion::nullOrNotBlank($groupLabel);

        $this->children = $children;
        $this->groupLabel = $groupLabel;
    }
}

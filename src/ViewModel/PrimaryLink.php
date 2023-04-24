<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class PrimaryLink implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $link;

    public function __construct(Link $link, string $checkPMC = null)
    {
        Assertion::notBlank($link);

        $this->link = $link;
        $this->checkPMC = $checkPMC;
    }
}

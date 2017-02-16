<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class Link implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $name;
    private $url = null;
    private $isCurrent;

    public function __construct(string $name, string $url = null, bool $isCurrent = false)
    {
        Assertion::notBlank($name);

        $this->name = $name;
        $this->url = $url;
        if ($isCurrent) {
            $this->isCurrent = true;
        }
    }
}

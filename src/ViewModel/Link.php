<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class Link implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $name;
    private $url;

    public function __construct(string $name, string $url)
    {
        Assertion::notBlank($name);
        Assertion::notBlank($url);

        $this->name = $name;
        $this->url = $url;
    }
}

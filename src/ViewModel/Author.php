<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class Author implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $name;
    private $url;

    public function __construct(string $name, string $url = null)
    {
        Assertion::notBlank($name);

        $this->name = $name;
        $this->url = $url;
    }

    public static function asLink(Link $link)
    {
        return new static(
          $link['name'],
          $link['url']
        );
    }
}

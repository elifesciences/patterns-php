<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class TabbedNavigationLink implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $name;
    private $url;
    private $selectedClass;

    private function __construct(string $name, string $url, string $selectedClass = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->selectedClass = $selectedClass;
    }

    public static function fromLink(Link $link, string $selectedClass = null)
    {
        return new static($link['name'], $link['url'], $selectedClass);
    }
}

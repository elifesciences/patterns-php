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
    private $classes;

    private function __construct(string $name, string $url, string $classes = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->classes = $classes;
    }

    public static function fromLink(Link $link, string $classes = null)
    {
        return new static($link['name'], $link['url'], $classes);
    }
}

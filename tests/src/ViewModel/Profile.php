<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel\Link;

final class Profile implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $name;
    private $link;
    private $avatar;

    private function __construct(string $name, string $link = null, array $avatar = [])
    {
        $this->name = $name;
        $this->link = $link;
        $this->avatar = $avatar;
    }

    public static function asLink(Link $link, array $avatar = [])
    {
        return new static(
            $link['name'],
            $link['url'],
            $avatar
        );
    }

    public static function asText($name, array $avatar = [])
    {
        return new static(
            $name,
            null,
            $avatar
        );
    }
}

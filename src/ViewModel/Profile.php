<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class Profile implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

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

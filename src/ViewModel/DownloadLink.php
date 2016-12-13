<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class DownloadLink implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $name;
    private $url;
    private $fileName;

    private function __construct(string $name, string $url, string $fileName = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->fileName = $fileName;
    }

    public static function fromLink(Link $link, string $fileName = null)
    {
        return new static($link['name'], $link['url'], $fileName);
    }
}

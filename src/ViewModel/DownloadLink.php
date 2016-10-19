<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

class DownloadLink implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $name;
    private $url;
    private $fileName;

    public function __construct(string $name, string $url = null, string $fileName = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->fileName = $fileName;
    }

    public static function fromLink(Link $link, string $fileName)
    {
        return new static($link['name'], $link['url'], $fileName);
    }
}

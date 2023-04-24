<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class DownloadLink implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $link;
    private $fileName;

    public function __construct(Link $link, string $fileName = null)
    {
        $this->link = $link;
        $this->fileName = $fileName;
    }
}

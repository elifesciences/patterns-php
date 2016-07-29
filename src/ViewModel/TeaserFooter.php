<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class TeaserFooter implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $meta;
    private $vor;
    private $downloadSrc;

    public function __construct(
        Meta $meta,
        bool $vor = null,
        string $downloadSrc = null
    ) {
        $this->meta = $meta;
        $this->vor = $vor;
        $this->downloadSrc = $downloadSrc;
    }
}

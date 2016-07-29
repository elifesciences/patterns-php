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
    private $downloadSrc;
    private $publishState;

    public function __construct(
        Meta $meta,
        bool $vor = null,
        string $downloadSrc = null
    ) {
        $this->meta = $meta;
        $this->publishState = [
            'vor' => $vor,
        ];
        $this->downloadSrc = $downloadSrc;
    }
}

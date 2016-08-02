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

    private function __construct(
        Meta $meta,
        bool $vor = null,
        string $downloadSrc = null
    ) {
        $this->meta = $meta;
        if (null !== $vor) {
            $this->publishState = [
                'vor' => $vor,
            ];
        }
        $this->downloadSrc = $downloadSrc;
    }

    public static function forArticle(
        Meta $meta,
        bool $vor
    ) {
        return new static($meta, $vor);
    }

    public static function forNonArticle(
        Meta $meta,
        string $downloadSrc = null
    ) {
        return new static($meta, null, $downloadSrc);
    }
}

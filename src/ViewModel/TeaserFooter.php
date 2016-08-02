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
    private $assetsPath;

    private function __construct(
        Meta $meta,
        bool $vor = null,
        string $downloadSrc = null,
        string $assetsPath = null
    ) {
        $this->meta = $meta;
        if (null !== $vor) {
            $this->publishState = [
                'vor' => $vor,
            ];
            $this->assetsPath = $assetsPath;
        }
        $this->downloadSrc = $downloadSrc;
    }

    public static function forArticle(
        Meta $meta,
        bool $vor,
        string $assetsPath
    ) {
        return new static($meta, $vor, null, $assetsPath);
    }

    public static function forNonArticle(
        Meta $meta,
        string $downloadSrc = null
    ) {
        return new static($meta, null, $downloadSrc);
    }
}

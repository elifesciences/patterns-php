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
    private $assetPath;

    private function __construct(
        Meta $meta,
        bool $vor = null,
        string $downloadSrc = null,
        string $assetPath = null
    ) {
        $this->meta = $meta;
        if (null !== $vor) {
            $this->publishState = [
                'vor' => $vor,
            ];
            $this->assetPath = $assetPath;
        }
        $this->downloadSrc = $downloadSrc;
    }

    public static function forArticle(
        Meta $meta,
        bool $vor,
        string $assetPath
    ) {
        return new static($meta, $vor, null, $assetPath);
    }

    public static function forNonArticle(
        Meta $meta,
        string $downloadSrc = null
    ) {
        return new static($meta, null, $downloadSrc);
    }
}

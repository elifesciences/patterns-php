<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\HasAssets;
use Traversable;

final class TeaserFooter implements CastsToArray, HasAssets
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $meta;
    private $publishState;

    private function __construct(
        Meta $meta,
        bool $vor = null
    ) {
        $this->meta = $meta;
        if (null !== $vor) {
            $this->publishState = [
                'vor' => $vor,
            ];
        }
    }

    public static function forArticle(
        Meta $meta,
        bool $vor
    ) {
        return new static($meta, $vor, null);
    }

    public static function forNonArticle(
        Meta $meta
    ) {
        return new static($meta);
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->meta;
    }
}

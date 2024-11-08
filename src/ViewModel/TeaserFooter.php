<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class TeaserFooter implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $meta;

    private function __construct(
        Meta $meta
    ) {
        $this->meta = $meta;
    }

    public static function forArticle(
        Meta $meta
    ) {
        return new static($meta);
    }

    public static function forNonArticle(
        Meta $meta
    ) {
        return new static($meta);
    }
}

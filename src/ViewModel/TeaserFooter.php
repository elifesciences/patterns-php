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
    private $terms;

    private function __construct(
        Meta $meta,
        $terms = null
    ) {
        $this->meta = $meta;
        $this->terms = $terms;
    }

    public static function forArticle(
        Meta $meta,
        $terms = null
    ) {
        return new static($meta, $terms);
    }

    public static function forNonArticle(
        Meta $meta
    ) {
        return new static($meta);
    }
}

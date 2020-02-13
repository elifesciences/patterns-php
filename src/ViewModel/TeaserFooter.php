<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class TeaserFooter implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $meta;
    private $formats;

    private function __construct(
        Meta $meta,
        array $formats = []
    ) {
        Assertion::allString($formats);

        $this->meta = $meta;
        if ($formats) {
            $this->formats = ['list' => $formats];
        }
    }

    public static function forArticle(
        Meta $meta,
        array $formats = []
    ) {
        return new static($meta, $formats);
    }

    public static function forNonArticle(
        Meta $meta
    ) {
        return new static($meta);
    }
}

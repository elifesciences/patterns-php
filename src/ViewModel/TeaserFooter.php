<?php

namespace eLife\Patterns\ViewModel;

use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ComposedAssets;
use Traversable;

final class TeaserFooter implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use ComposedAssets;

    private $meta;
    private $formats;

    private function __construct(
        Meta $meta,
        bool $html = false,
        bool $pdf = false
    ) {
        $this->meta = $meta;
        $this->formats = array_filter(compact('html', 'pdf'));
    }

    public static function forArticle(
        Meta $meta,
        bool $html = false,
        bool $pdf = false
    ) {
        return new static($meta, $html, $pdf);
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

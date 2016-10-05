<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromNullProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\ViewModel;
use Traversable;

final class SourceData implements ViewModel
{
    use ArrayFromNullProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $text;
    private $nonDoiLink;
    private $doi;

    private function __construct(string $text, string $nonDoiLink = null, Doi $doi = null)
    {
        Assertion::notBlank($text);

        $this->text = $text;
        $this->nonDoiLink = $nonDoiLink;
        $this->doi = $doi;
    }

    public static function withDoi(string $text, Doi $doi)
    {
        return new static($text, null, $doi);
    }

    public static function withoutDoi(string $text, string $nonDoiLink)
    {
        Assertion::notBlank($nonDoiLink);

        return new static($text, $nonDoiLink);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/source-data.mustache';
    }

    public function getLocalStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/source-data.css';
    }

    protected function getComposedViewModels() : Traversable
    {
        if ($this->doi) {
            yield $this->doi;
        }
    }
}

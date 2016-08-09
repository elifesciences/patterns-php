<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ComposedAssets;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Meta implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use ComposedAssets;

    private $url;
    private $text;
    private $date;

    private function __construct(string $url = null, string $text = null, Date $date = null)
    {
        if ($date instanceof Date) {
            Assertion::false($date['isExpanded']);
        }

        $this->url = $url;
        $this->text = $text;
        $this->date = $date;
    }

    public static function withLink(Link $link, Date $date = null) : Meta
    {
        return new self($link['url'], $link['name'], $date);
    }

    public static function withText(string $text, Date $date = null) : Meta
    {
        Assertion::minLength($text, 1);

        return new self(null, $text, $date);
    }

    public static function withDate(Date $date) : Meta
    {
        return new self(null, null, $date);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/meta.mustache';
    }

    protected function getComposedViewModels() : Traversable
    {
        yield $this->date;
    }
}

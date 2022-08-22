<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ViewModel;

final class Meta implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $url;
    private $text;
    private $date;
    private $isReviewed;

    private function __construct(string $url = null, string $text = null, Date $date = null)
    {
        if ($date instanceof Date) {
            Assertion::false($date['isExpanded']);
        }

        $this->url = $url ?? false;
        $this->text = $text;
        $this->date = $date;
        if ("Reviewed preprint" === $text) {
            $this->isReviewed = true;
        }
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
        return 'resources/templates/meta.mustache';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class TeaserImage implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $defaultPath;
    private $altText;
    private $url;
    private $srcset;
    private $classes;

    const STYLE_PROMINENT = 'teaser__img--prominent';
    const STYLE_BIG = 'teaser__img--big';
    const STYLE_SMALL = 'teaser__img--small';

    public function __construct(
        string $defaultPath,
        string $altText = null,
        string $url = null,
        array $srcset = null,
        array $classes = null
    ) {
        Assertion::notBlank($defaultPath);

        $this->defaultPath = $defaultPath;
        $this->altText = $altText;
        $this->url = $url;
        $this->srcset = $this->srcsetFromArray($srcset);
        if ($classes) {
            Assertion::allInArray($classes, [self::STYLE_PROMINENT, self::STYLE_BIG, self::STYLE_SMALL]);
            $this->classes = implode(' ', $classes);
        }
    }

    public static function prominent(
        string $defaultPath,
        string $altText,
        string $url = null,
        array $srcset = null
    ) {
        return new static (
            $defaultPath,
            $altText,
            $url,
            $srcset,
            [self::STYLE_PROMINENT]
        );
    }

    public static function big(
        string $defaultPath,
        string $altText,
        string $url = null,
        array $srcset = null
    ) {
        return new static (
            $defaultPath,
            $altText,
            $url,
            $srcset,
            [self::STYLE_BIG]
        );
    }

    public static function small(
        string $defaultPath,
        string $altText,
        string $url = null,
        array $srcset = null
    ) {
        return new static (
            $defaultPath,
            $altText,
            $url,
            $srcset,
            [self::STYLE_SMALL]
        );
    }

    private function srcsetFromArray(array $array = null) : string
    {
        if ($array === null) {
            return '';
        }
        $srcsets = [];
        foreach ($array as $width => $src) {
            $srcsets[] = $src.' '.$width.'w';
        }

        return implode(', ', $srcsets);
    }
}

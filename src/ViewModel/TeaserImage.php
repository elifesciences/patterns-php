<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class TeaserImage implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $defaultPath;
    private $altText;
    private $srcset;
    private $classes;

    const STYLE_PROMINENT = 'teaser__img--prominent';
    const STYLE_BIG = 'teaser__img--big';
    const STYLE_SMALL = 'teaser__img--small';

    private function __construct(
        string $path1x,
        string $path2x = null,
        string $altText = '',
        array $classes = null
    ) {
        Assertion::notBlank($path1x);

        $this->defaultPath = $path1x;
        if ($path2x) {
            $this->srcset = "{$path2x} 2x";
        }
        $this->altText = $altText;
        if ($classes) {
            Assertion::allInArray($classes, [self::STYLE_PROMINENT, self::STYLE_BIG, self::STYLE_SMALL]);
            $this->classes = implode(' ', $classes);
        }
    }

    public static function prominent(
        string $path1x,
        string $path2x = null,
        string $altText = ''
    ) {
        return new static (
            $path1x,
            $path2x,
            $altText,
            [self::STYLE_PROMINENT]
        );
    }

    public static function big(
        string $path1x,
        string $path2x = null,
        string $altText = ''
    ) {
        return new static (
            $path1x,
            $path2x,
            $altText,
            [self::STYLE_BIG]
        );
    }

    public static function small(
        string $path1x,
        string $path2x = null,
        string $altText = ''
    ) {
        return new static (
            $path1x,
            $path2x,
            $altText,
            [self::STYLE_SMALL]
        );
    }
}

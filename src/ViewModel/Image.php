<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class Image implements CastsToArray, IsCaptioned
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $altText;
    private $defaultPath;
    private $srcset;
    private $classes;

    public function __construct(string $path1x, string $path2x = null, string $altText = '', array $classes = null)
    {
        Assertion::notBlank($path1x);

        $this->defaultPath = $path1x;
        $this->srcset = [];
        if ($path2x) {
            $this->srcset = "{$path2x} 2x";
        }
        $this->altText = $altText;
        $this->classes = $classes ? implode(' ', $classes) : null;
    }
}

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

    public function __construct(string $defaultPath, array $srcset = [], string $altText = '', array $classes = null)
    {
        Assertion::notBlank($defaultPath);
        Assertion::allInteger(array_keys($srcset));
        Assertion::allNotBlank($srcset);

        $this->defaultPath = $defaultPath;
        $this->srcset = [];
        if ($srcset) {
            foreach ($srcset as $width => $src) {
                $this->srcset[] = $src.' '.$width.'w';
            }
            $this->srcset = implode(', ', $this->srcset);
        }
        $this->altText = $altText;
        $this->classes = $classes ? implode(' ', $classes) : null;
    }
}

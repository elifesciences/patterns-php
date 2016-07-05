<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class Image implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $altText;
    private $classes;
    private $defaultPath;
    private $srcset;

    public function __construct(string $defaultPath, array $srcset, string $altText = '', array $classes = [])
    {
        Assertion::notBlank($defaultPath);
        Assertion::notEmpty($srcset);
        Assertion::allInteger(array_keys($srcset));
        Assertion::allNotBlank($srcset);
        Assertion::allString($classes);

        $this->defaultPath = $defaultPath;
        $this->srcset = [];
        foreach ($srcset as $width => $src) {
            $this->srcset[] = $src.' '.$width.'w';
        }
        $this->srcset = implode(', ', $this->srcset);
        $this->altText = $altText;
        $this->classes = implode(' ', $classes);
    }

    public function addClass($className) {
        $this->classes = trim($this->classes . ' ' . $className);
        return $this;
    }
}

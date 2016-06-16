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

    private $defaultPath;
    private $srcset;
    private $altText;

    public function __construct(string $defaultPath, array $srcset, string $altText = '')
    {
        Assertion::notBlank($defaultPath);
        Assertion::notEmpty($srcset);
        Assertion::allInteger(array_keys($srcset));
        Assertion::allNotBlank($srcset);

        $this->defaultPath = $defaultPath;
        $this->srcset = [];
        foreach ($srcset as $width => $src) {
            $this->srcset[] = $src . ' ' . $width . 'w';
        }
        $this->srcset = implode(', ', $this->srcset);

        $this->altText = $altText;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class SimpleImage implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $path;
    private $altText;

    public function __construct(string $path, string $altText)
    {
        Assertion::notBlank($path);
        Assertion::notBlank($altText);

        $this->path = $path;
        $this->altText = $altText;
    }
}

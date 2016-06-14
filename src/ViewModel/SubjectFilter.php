<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class SubjectFilter implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $name;
    private $value;
    private $text;

    public function __construct(string $name, string $value, string $text)
    {
        Assertion::notBlank($name);
        Assertion::notBlank($value);
        Assertion::notBlank($text);

        $this->name = $name;
        $this->value = $value;
        $this->text = $text;
    }
}

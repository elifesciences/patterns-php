<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class TableFootnote implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $text;
    private $id;

    public function __construct(string $text, string $id = null)
    {
        Assertion::notBlank($text);

        $this->text = $text;
        $this->id = $id;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

final class Message implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $text;
    private $id;

    public function __construct(
        string $text,
        string $id
    ) {
        Assertion::notBlank($text);
        Assertion::notBlank($id);

        $this->text = $text;
        $this->id = $id;
    }
}

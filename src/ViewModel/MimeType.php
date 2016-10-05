<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class MimeType implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $forMachine;
    private $forHuman;

    public function __construct(string $forMachine, string $forHuman)
    {
        Assertion::true(
            strpos($forMachine, 'audio') === 0 ||
            strpos($forMachine, 'video') === 0
        );
        Assertion::notBlank($forHuman);

        $this->forMachine = $forMachine;
        $this->forHuman = $forHuman;
    }
}

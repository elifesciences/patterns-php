<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use InvalidArgumentException;

final class MessageGroup implements CastsToArray
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $errorText;
    private $infoText;
    private $id;

    public function __construct(
        string $errorText,
        string $infoText,
        string $id
    ) {
        Assertion::string($errorText);
        Assertion::string($infoText);
        Assertion::notBlank($id);

        if($errorText === '' && $infoText === '')
        {
            throw new InvalidArgumentException('A MessageGroup must contain at least one message.');
        }

        $this->errorText = $errorText;
        $this->infoText = $infoText;
        $this->id = $id;
    }
}

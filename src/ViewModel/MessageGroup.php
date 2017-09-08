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

    private $id;
    private $errorText;
    private $infoText;

    public function __construct(
        string $id,
        string $errorText = null,
        string $infoText = null
    ) {
        Assertion::notBlank($id);

        if (empty($errorText) && empty($infoText)) {
            throw new InvalidArgumentException('A MessageGroup must contain at least one message.');
        }

        $this->id = $id;
        $this->errorText = $errorText;
        $this->infoText = $infoText;
    }
}

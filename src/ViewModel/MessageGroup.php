<?php

namespace eLife\Patterns\ViewModel;

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
        string $errorText = null,
        string $infoText = null
    ) {
        if (empty($errorText) && empty($infoText)) {
            throw new InvalidArgumentException('A MessageGroup must contain at least one message.');
        }

        $this->id = 'messages_'.random_int(10e4, 10e8);
        $this->errorText = $errorText;
        $this->infoText = $infoText;
    }
}

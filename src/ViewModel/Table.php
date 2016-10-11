<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;

/**
 * @SuppressWarnings(ForbiddenAbleSuffix)
 */
final class Table implements IsCaptioned
{
    private $data;

    public function __construct(string $data)
    {
        Assertion::regex($data, '~^<table>.*<\/table>$~');
        $this->data = $data;
    }

    public function __toString() : string
    {
        return $this->data;
    }
}

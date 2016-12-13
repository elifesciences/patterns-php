<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;

/**
 * @SuppressWarnings(ForbiddenAbleSuffix)
 */
final class Table implements CastsToArray, IsCaptioned
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;

    private $tables;

    public function __construct(string ...$data)
    {
        Assertion::allRegex($data, '/^<table>[\s\S]+<\/table>$/');
        $this->tables = $data;
    }
}

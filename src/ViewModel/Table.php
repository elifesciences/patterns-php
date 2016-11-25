<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

/**
 * @SuppressWarnings(ForbiddenAbleSuffix)
 */
final class Table implements CastsToArray, IsCaptioned
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $tables;

    public function __construct(string ...$data)
    {
        Assertion::allRegex($data, '/^<table>[\s\S]+<\/table>$/');
        $this->tables = $data;
    }
}

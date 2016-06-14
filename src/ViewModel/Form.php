<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class Form implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $action;
    private $id;
    private $method;

    public function __construct(string $action, string $id, string $method)
    {
        Assertion::notBlank($action);
        Assertion::notBlank($id);
        Assertion::inArray($method, ['GET', 'POST']);

        $this->action = $action;
        $this->id = $id;
        $this->method = $method;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\CastsToArray;
use eLife\Patterns\ReadOnlyArrayAccess;

final class Input implements CastsToArray
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;

    private $label;
    private $type;
    private $name;
    private $value;
    private $placeholder;

    public function __construct(
        string $label,
        string $type,
        string $name,
        string $value = null,
        string $placeholder = null
    ) {
        Assertion::notBlank($label);
        Assertion::inArray($type, ['email', 'password', 'search', 'tel', 'text', 'url']);
        Assertion::notBlank($name);

        $this->label = $label;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class Select implements ViewModel
{
    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;

    private $id;
    private $options;
    private $label;

    public function __construct(string $id, array $options, FormLabel $label)
    {
        Assertion::notEmpty($options);
        Assertion::allIsInstanceOf($options, SelectOption::class);

        $this->id = $id;
        $this->options = $options;
        $this->label = $label;
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/select.mustache';
    }
}

<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class Select implements ViewModel
{
    use ArrayAccessFromProperties;
    use ArrayFromProperties;
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
        return 'resources/templates/select.mustache';
    }
}

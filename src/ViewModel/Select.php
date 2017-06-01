<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;

final class Select implements ViewModel
{
    const STATUS_ERROR = 'error';
    const STATUS_VALID = 'valid';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $id;
    private $options;
    private $label;
    private $name;
    private $required;
    private $disabled;
    private $classNames;

    public function __construct(
        string $id,
        array $options,
        FormLabel $label,
        string $name,
        bool $required = null,
        bool $disabled = null,
        string $status = null
    ) {
        Assertion::notEmpty($options);
        Assertion::allIsInstanceOf($options, SelectOption::class);
        Assertion::nullOrChoice($status, [self::STATUS_ERROR, self::STATUS_VALID]);

        $this->id = $id;
        $this->options = $options;
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->disabled = $disabled;
        if (!empty($status)) {
            $this->classNames = "select--$status";
        }
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/select.mustache';
    }
}

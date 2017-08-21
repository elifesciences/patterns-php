<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayAccessFromProperties;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

final class Select implements ViewModel
{
    const STATE_ERROR = 'error';
    const STATE_VALID = 'valid';

    use ArrayAccessFromProperties;
    use ArrayFromProperties;
    use SimplifyAssets;

    private $id;
    private $options;
    private $label;
    private $name;
    private $required;
    private $disabled;
    private $state;
    private $message;

    public function __construct(
        string $id,
        array $options,
        FormLabel $label,
        string $name,
        bool $required = null,
        bool $disabled = null,
        string $state = null,
        string $message = null
    ) {
        Assertion::notEmpty($options);
        Assertion::allIsInstanceOf($options, SelectOption::class);
        Assertion::nullOrChoice($state, [self::STATE_ERROR, self::STATE_VALID]);

        $this->id = $id;
        $this->options = $options;
        $this->label = $label;
        $this->name = $name;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->state = $state;
        $this->message = $message;
    }

    public function getTemplateName() : string
    {
        return 'resources/templates/select.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield 'resources/assets/css/select.css';
        yield 'resources/assets/css/form-item.css';
    }
}

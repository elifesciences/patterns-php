<?php

namespace eLife\Patterns\ViewModel;

use Assert\Assertion;
use eLife\Patterns\ArrayFromProperties;
use eLife\Patterns\ReadOnlyArrayAccess;
use eLife\Patterns\SimplifyAssets;
use eLife\Patterns\ViewModel;
use Traversable;

class TextField implements ViewModel
{

    use ArrayFromProperties;
    use ReadOnlyArrayAccess;
    use SimplifyAssets;
    
    private $inputType;
    private $label;
    private $name;
    private $classNames;

    protected function __construct(
        string $inputType,
        /* Label */ $label,
        string $name = null,
        array $classNames = []
    ) {
        Assertion::notBlank($inputType);
        Assertion::inArray($inputType, ['text', 'email']);

        $this->inputType = $inputType;
        $this->label = $label;
        $this->name = $name;
        $this->classNames = implode(' ', $classNames);
    }

    static public function textInput($label, $name = null, $classNames = []) {
        return new static('text', $label, $name, $classNames);
    }

    static public function emailInput($label, $name = null, $classNames = []) {
        return new static('email', $label, $name, $classNames);
    }

    public function getTemplateName() : string
    {
        return '/elife/patterns/templates/text-field.mustache';
    }

    public function getStyleSheets() : Traversable
    {
        yield '/elife/patterns/assets/css/text-field.css';
    }
}

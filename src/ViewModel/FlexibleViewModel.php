<?php

namespace eLife\Patterns\ViewModel;

use BadMethodCallException;
use eLife\Patterns\ViewModel;
use ReturnTypeWillChange;

final class FlexibleViewModel implements ViewModel
{
    private $templateName;
    private $properties;

    public function __construct(
        string $templateName,
        array $properties
    ) {
        $this->templateName = $templateName;
        $this->properties = $properties;
    }

    public static function fromViewModel(ViewModel $viewModel) : FlexibleViewModel
    {
        return new self(
            $viewModel->getTemplateName(),
            $viewModel->toArray()
        );
    }

    public function withProperty(string $key, $value) : FlexibleViewModel
    {
        $viewModel = self::fromViewModel($this);
        $viewModel->properties[$key] = $value;

        return $viewModel;
    }

    public function toArray() : array
    {
        return $this->properties;
    }

    #[ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->properties[$offset]);
    }

    #[ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->properties[$offset];
        }

        return null;
    }

    #[ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException('Object is immutable');
    }

    #[ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        throw new BadMethodCallException('Object is immutable');
    }

    public function getTemplateName() : string
    {
        return $this->templateName;
    }
}

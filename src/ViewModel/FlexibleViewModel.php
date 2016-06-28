<?php

namespace eLife\Patterns\ViewModel;

use ArrayObject;
use BadMethodCallException;
use eLife\Patterns\ViewModel;
use Traversable;

final class FlexibleViewModel implements ViewModel
{
    private $templateName;
    private $properties;
    private $styleSheets;
    private $inlineStyleSheets;
    private $javaScripts;
    private $inlineJavaScripts;

    public function __construct(
        string $templateName,
        array $properties,
        Traversable $styleSheets = null,
        Traversable $inlineStyleSheets = null,
        Traversable $javaScripts = null,
        Traversable $inlineJavaScripts = null
    ) {
        $this->templateName = $templateName;
        $this->properties = $properties;
        $this->styleSheets = $styleSheets ?? new ArrayObject();
        $this->inlineStyleSheets = $inlineStyleSheets ?? new ArrayObject();
        $this->javaScripts = $javaScripts ?? new ArrayObject();
        $this->inlineJavaScripts = $inlineJavaScripts ?? new ArrayObject();
    }

    public function toArray() : array
    {
        return $this->properties;
    }

    public function offsetExists($offset)
    {
        return isset($this->properties[$offset]);
    }

    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->properties[$offset];
        }

        return null;
    }

    public function offsetSet($offset, $value)
    {
        throw new BadMethodCallException('Object is immutable');
    }

    public function offsetUnset($offset)
    {
        throw new BadMethodCallException('Object is immutable');
    }

    public function getTemplateName() : string
    {
        return $this->templateName;
    }

    public function getStyleSheets() : Traversable
    {
        return $this->styleSheets;
    }

    public function getInlineStyleSheets() : Traversable
    {
        return $this->inlineStyleSheets;
    }

    public function getJavaScripts() : Traversable
    {
        return $this->javaScripts;
    }

    public function getInlineJavaScripts() : Traversable
    {
        return $this->inlineJavaScripts;
    }
}

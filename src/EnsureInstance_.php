<?php

/**
 * If the schema validation is changed to allow some stylesheets but not other,
 * this can instead return a NULL object that has a blank "getStyleSheets" method
 * or something similar.
 */

namespace eLife\Patterns;

use ReflectionClass;

trait EnsureInstance
{
    public function ensureInstance($instance, string $class, array $properties = [], callable $fn = null)
    {
        if ($instance instanceof $class) {
            return $instance;
        }
        $reflector = (new ReflectionClass($class));
        $instance = $reflector->newInstanceWithoutConstructor();
        foreach ($properties as $propertyName => $propertyValue) {
            $prop = $reflector->getProperty($propertyName);
            $prop->setAccessible(true);
            $prop->setValue($instance, $propertyValue);
        }
        if ($fn) {
            $instance = $fn($reflector, $instance);
        }

        return $instance;
    }
}

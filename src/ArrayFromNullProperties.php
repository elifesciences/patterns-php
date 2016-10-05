<?php
/**
 * Array from properties.
 *
 * This may be a bug in the validation script. For the source data
 * pattern a null value for DOI is required. I've tweaked the array
 * from properties here as an intermediate fix.
 *
 * @author Stephen Fraser <stephen.fraser@digirati.com>
 */

namespace eLife\Patterns;

trait ArrayFromNullProperties
{
    final public function toArray() : array
    {
        $vars = [];

        foreach (get_object_vars($this) as $key => $value) {
            if ('_' === substr($key, 0, 1)) {
                continue;
            }

            $value = $this->handleValue($value);

            if ([] !== $value) { // This is the line that was changed.
                $vars[$key] = $value;
            }
        }

        return $vars;
    }

    private function handleValue($value)
    {
        if (is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                $value[$subKey] = $this->handleValue($subValue);
            }
        }

        if ($value instanceof CastsToArray) {
            return $value->toArray();
        }

        return $value;
    }
}

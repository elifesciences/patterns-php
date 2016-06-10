<?php

namespace eLife\Patterns;

trait ArrayFromProperties
{
    final public function toArray() : array
    {
        $vars = [];

        foreach (get_object_vars($this) as $key => $value) {
            if ($value instanceof CastsToArray) {
                $value = $value->toArray();
            }

            $vars[$key] = $value;
        }

        return $vars;
    }
}

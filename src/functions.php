<?php

namespace eLife\Patterns;

use Traversable;

/**
 * Converts traversable type to array with optional distinct.
 *
 * @param Traversable $traversable
 * @param bool $distinct
 *
 * @return array
 */
function traversable_to_array(Traversable $traversable, $distinct = true) : array
{
    $array = [];
    foreach ($traversable as $t) {
        $array[] = $t;
    }

    return $distinct ? array_unique($array) : $array;
}

/**
 * Flattens a multi-dimensional array.
 *
 * @internal
 *
 * @param $item
 *
 * @return Traversable
 */
function flatten($item) : Traversable
{
    if (is_iterable($item)) {
        foreach ($item as $value) {
            foreach (flatten($value) as $flattenedValue) {
                yield $flattenedValue;
            }
        }
    } else {
        yield $item;
    }
}

/**
 * If we can iterate.
 *
 * @internal
 *
 * @param $item
 *
 * @return bool
 */
function is_iterable($item) : bool
{
    return is_array($item) || $item instanceof Traversable;
}

function mixed_visibility_text(string $prefix = '', string $text, string $suffix = '') : string
{
    $wrappedPrefix = '';
    $wrappedSuffix = '';

    if (false === empty($prefix)) {
        $wrappedPrefix = '<span class="visuallyhidden">'.$prefix.' </span>';
    }
    if (false === empty($suffix)) {
        $wrappedSuffix = '<span class="visuallyhidden"> '.$suffix.'</span>';
    }

    return $wrappedPrefix.$text.$wrappedSuffix;
}

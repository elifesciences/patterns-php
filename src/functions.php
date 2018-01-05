<?php

namespace eLife\Patterns;

use Traversable;

/**
 * Converts traversable type to unique array.
 */
function iterator_to_unique_array(Traversable $traversable) : array
{
    return array_unique(iterator_to_array($traversable, false));
}

/**
 * Flattens a multi-dimensional iterable.
 *
 * @internal
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
 */
function is_iterable($item) : bool
{
    return is_array($item) || $item instanceof Traversable;
}

function mixed_visibility_text(string $prefix, string $text, string $suffix = '') : string
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

function mixed_accessibility_text(
    string $visibleInaccessiblePrefix,
    string $hiddenAccessibleText,
    string $visibleInaccessibleSuffix = '') : string
{
    $wrappedVisibleInaccessibleTextPrefix = '';
    $wrappedVisibleInaccessibleTextSuffix = '';

    if (false === empty($visibleInaccessiblePrefix)) {
        $wrappedVisibleInaccessibleTextPrefix = '<span aria-hidden="true">'.$visibleInaccessiblePrefix.' </span>';
    }
    if (false === empty($visibleInaccessibleSuffix)) {
        $wrappedVisibleInaccessibleTextSuffix = '<span aria-hidden="true"> '.$visibleInaccessibleSuffix.'</span>';
    }

    return $wrappedVisibleInaccessibleTextPrefix.mixed_visibility_text($hiddenAccessibleText, $wrappedVisibleInaccessibleTextSuffix);
}

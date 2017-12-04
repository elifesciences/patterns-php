<?php

namespace tests\eLife\Patterns;

use ArrayObject;
use PHPUnit_Framework_TestCase;
use function eLife\Patterns\flatten;
use function eLife\Patterns\is_iterable;
use function eLife\Patterns\iterator_to_unique_array;
use function eLife\Patterns\mixed_accessibility_text;
use function eLife\Patterns\mixed_visibility_text;

final class FunctionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function iterator_to_unique_array()
    {
        $fn1 = function () {
            yield 'foo';
            yield 'bar';
            yield 'bar';
        };
        $fn2 = function () use ($fn1) {
            yield 'baz';
            yield from $fn1();
        };

        $this->assertSame(['baz', 'foo', 'bar'], iterator_to_unique_array($fn2()));
        $this->assertSame(['baz', 'foo', 'bar', 'bar'], iterator_to_array($fn2(), false));
    }

    /**
     * @test
     */
    public function flatten()
    {
        $input = [
            'foo',
            'foo',
            [
                'foo',
                'bar',
            ],
            [
                new ArrayObject(['qux']),
            ],
            'bar',
        ];

        $expected = [
            'foo',
            'foo',
            'foo',
            'bar',
            'qux',
            'bar',
        ];

        $this->assertEquals($expected, iterator_to_array(flatten($input)));
    }

    /**
     * @test
     * @dataProvider IterableProvider
     */
    public function is_iterable($item, bool $expected)
    {
        $this->assertSame($expected, is_iterable($item));
    }

    public function IterableProvider()
    {
        return [
            ['foo', false],
            [1, false],
            [[], true],
            [new ArrayObject(), true],
        ];
    }

    /**
     * @test
     * @dataProvider MixedVisibilityTextProvider
     */
    public function mixed_visibility_text(array $item, string $expected)
    {
        $this->assertSame($expected, mixed_visibility_text($item[0], $item[1], $item[2]));
    }

    public function MixedVisibilityTextProvider()
    {
        return [
            [
                ['hidden prefix', 'visible text', ''],
                '<span class="visuallyhidden">hidden prefix </span>visible text',
            ],
            [
                ['', 'visible text', 'hidden suffix'],
                'visible text<span class="visuallyhidden"> hidden suffix</span>',
            ],
            [
                ['hidden prefix', 'visible text', 'hidden suffix'],
                '<span class="visuallyhidden">hidden prefix </span>visible text<span class="visuallyhidden"> hidden suffix</span>',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider MixedAccessibilityTextProvider
     */
    public function mixed_accessibility_text(array $item, string $expected)
    {
        $this->assertSame($expected, mixed_accessibility_text($item[0], $item[1], $item[2]));
    }

    public function MixedAccessibilityTextProvider()
    {
        return [
            [
                ['visible, inaccessible text', 'hidden, accessible text', ''],
                '<span aria-hidden="true">visible, inaccessible text </span><span class="visuallyhidden">hidden, accessible text </span>',
            ],
            [
                ['', 'hidden, accessible text', 'visible, inaccessible text'],
                '<span class="visuallyhidden">hidden, accessible text </span><span aria-hidden="true"> visible, inaccessible text</span>',
            ]
        ];
    }
}

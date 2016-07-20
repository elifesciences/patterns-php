<?php

namespace tests\eLife\Patterns;

use ArrayObject;
use PHPUnit_Framework_TestCase;
use function eLife\Patterns\flatten;
use function eLife\Patterns\is_traversable;
use function eLife\Patterns\mixed_visibility_text;
use function eLife\Patterns\sanitise_array;
use function eLife\Patterns\sanitise_traversable;

final class FunctionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function sanitise_traversable()
    {
        $input = new ArrayObject([
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
        ]);

        $expected = [
            'bar',
            'foo',
            'qux',
        ];

        $this->assertEquals($expected, iterator_to_array(sanitise_traversable($input)));
    }

    /**
     * @test
     */
    public function sanitise_array()
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
            'bar',
            'foo',
            'qux',
        ];

        $this->assertEquals($expected, sanitise_array($input));
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
     * @dataProvider TraversableProvider
     */
    public function is_traversable($item, bool $expected)
    {
        $this->assertSame($expected, is_traversable($item));
    }

    public function TraversableProvider()
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
}

<?php

namespace tests\eLife\Patterns;

use ArrayObject;
use function eLife\Patterns\flatten;
use function eLife\Patterns\is_traversable;
use function eLife\Patterns\sanitise_array;
use function eLife\Patterns\sanitise_traversable;
use PHPUnit_Framework_TestCase;

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
}

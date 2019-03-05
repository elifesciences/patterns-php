<?php

namespace tests\eLife\Patterns;

use function eLife\Patterns\mixed_accessibility_text;
use function eLife\Patterns\mixed_visibility_text;
use PHPUnit_Framework_TestCase;

final class FunctionsTest extends PHPUnit_Framework_TestCase
{
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
                ['visible, inaccessible prefix', 'hidden, accessible text', ''],
                '<span aria-hidden="true">visible, inaccessible prefix</span><span class="visuallyhidden"> hidden, accessible text</span>',
            ],
            [
                ['', 'hidden, accessible text', 'visible, inaccessible suffix'],
                '<span class="visuallyhidden">hidden, accessible text </span><span aria-hidden="true">visible, inaccessible suffix</span>',
            ],
            [
                ['visible, inaccessible prefix', 'hidden, accessible text', 'visible, inaccessible suffix'],
                '<span aria-hidden="true">visible, inaccessible prefix</span><span class="visuallyhidden"> hidden, accessible text</span><span aria-hidden="true"> visible, inaccessible suffix</span>',
            ],
        ];
    }
}

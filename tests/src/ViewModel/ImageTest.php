<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Image;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class ImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $image = new Image('/foo.png', [10 => '/bar.png']);

        $this->assertInstanceOf(CastsToArray::class, $image);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'altText' => 'altText',
            'defaultPath' => '/foo.png',
            'srcset' => '/bar.png 10w, /baz.png 20w',
        ];

        $image = new Image('/foo.png', [10 => '/bar.png', 20 => '/baz.png'], 'altText');

        $this->assertSame($data['defaultPath'], $image['defaultPath']);
        $this->assertSame($data['srcset'], $image['srcset']);
        $this->assertSame($data['altText'], $image['altText']);
        $this->assertSame($data, $image->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_default_path()
    {
        $this->expectException(InvalidArgumentException::class);

        new Image('', [10 => '/bar.png', 20 => '/baz.png']);
    }

    /**
     * @test
     */
    public function it_cannot_have_an_empty_srcset()
    {
        $this->expectException(InvalidArgumentException::class);

        new Image('/foo.png', []);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_srcset_path()
    {
        $this->expectException(InvalidArgumentException::class);

        new Image('/foo.png', [10 => '', 20 => '/baz.png']);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_non_integer_srcset_key()
    {
        $this->expectException(InvalidArgumentException::class);

        new Image('/foo.png', ['bar' => '/bar.png', 20 => '/baz.png']);
    }
}

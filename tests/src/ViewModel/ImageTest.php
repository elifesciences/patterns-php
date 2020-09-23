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
        $image = new Image('/foo.png', ['1' => '/bar.png']);

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
            'srcset' => '/baz.png 2x, /bar.png 1x',
            'sizes' => '10px',
        ];

        $image = new Image('/foo.png', ['2' => '/baz.png', '1' => '/bar.png'], 'altText', '10px');

        $this->assertSame($data['defaultPath'], $image['defaultPath']);
        $this->assertSame($data['srcset'], $image['srcset']);
        $this->assertSame($data['altText'], $image['altText']);
        $this->assertSame($data['sizes'], $image['sizes']);
        $this->assertSame($data, $image->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_default_path()
    {
        $this->expectException(InvalidArgumentException::class);

        new Image('', ['1' => '/bar.png', '2' => '/baz.png']);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_srcset_path()
    {
        $this->expectException(InvalidArgumentException::class);

        new Image('/foo.png', ['1' => '', '2' => '/baz.png']);
    }

    /**
     * @test
     */
    public function it_must_have_all_srcsafe_keys_convertable_to_numbers()
    {
        $this->expectException(InvalidArgumentException::class);

        new Image('/foo.png', ['1' => '/bar.png', 'baz' => '/baz.png']);
    }

    /**
     * @test
     */
    public function it_must_have_a_srcset_key_of_1()
    {
        $this->expectException(InvalidArgumentException::class);

        new Image('/foo.png', ['2' => '/baz.png', '3' => '/quux.png']);
    }

    /**
     * @test
     */
    public function it_may_have_a_non_integer_srcset_key()
    {
        new Image('/foo.png', ['1' => '/bar.png', '1.5' => '/baz.png']);
    }
}

<?php

namespace src\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\SimpleImage;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class SimpleImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $image = new SimpleImage('/foo.png', 'altTestt');

        $this->assertInstanceOf(CastsToArray::class, $image);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'path' => '/foo.png',
            'altText' => 'altText',
        ];

        $image = new SimpleImage('/foo.png', 'altText');

        $this->assertSame($data['path'], $image['path']);
        $this->assertSame($data['altText'], $image['altText']);
        $this->assertSame($data, $image->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_path()
    {
        $this->expectException(InvalidArgumentException::class);

        new SimpleImage('', 'altText');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_alt_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new SimpleImage('/foo.png', '');
    }
}

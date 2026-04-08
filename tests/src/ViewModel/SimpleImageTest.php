<?php

namespace src\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\SimpleImage;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SimpleImageTest extends TestCase
{
    #[Test]
    public function it_casts_to_an_array()
    {
        $image = new SimpleImage('/foo.png', 'altTestt');

        $this->assertInstanceOf(CastsToArray::class, $image);
    }

    #[Test]
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

    #[Test]
    public function it_cannot_have_a_blank_path()
    {
        $this->expectException(InvalidArgumentException::class);

        new SimpleImage('', 'altText');
    }

    #[Test]
    public function it_cannot_have_a_blank_alt_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new SimpleImage('/foo.png', '');
    }
}

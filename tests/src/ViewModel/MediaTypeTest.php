<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\MediaType;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Traversable;

final class MediaTypeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $mediaType = new MediaType('audio/ogg');

        $this->assertInstanceOf(CastsToArray::class, $mediaType);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = ['forMachine' => 'audio/ogg', 'forHuman' => 'Ogg'];

        $mediaType = new MediaType('audio/ogg');

        $this->assertSame($data['forMachine'], $mediaType['forMachine']);
        $this->assertSame($data['forHuman'], $mediaType['forHuman']);
        $this->assertSame($data, $mediaType->toArray());
    }

    /**
     * @test
     * @dataProvider humanNameProvider
     */
    public function it_guesses_human_names(string $mediaType, string $expected)
    {
        $mediaType = new MediaType($mediaType);

        $this->assertSame($expected, $mediaType['forHuman']);
    }

    public function humanNameProvider() : Traversable
    {
        $types = [
            'application/ogg' => 'Ogg',
            'audio/mp4' => 'MPEG-4',
            'audio/mpeg' => 'MPEG',
            'audio/ogg' => 'Ogg',
            'audio/wave' => 'WAVE',
            'audio/wave; codecs=0' => 'WAVE',
            'audio/webm' => 'WebM',
            'image/gif' => 'GIF',
            'image/jpeg' => 'JPEG',
            'image/pjpeg' => 'JPEG',
            'image/png' => 'PNG',
            'image/tiff' => 'TIFF',
            'image/webp' => 'WebP',
            'video/mp4' => 'MPEG-4',
            'video/mp4; codecs="avc1.42E01E, mp4a.40.2"' => 'MPEG-4',
            'video/mpeg' => 'MPEG',
            'video/ogg' => 'Ogg',
            'video/webm' => 'WebM',
        ];

        foreach ($types as $forMachine => $forHuman) {
            yield $forMachine => [$forMachine, $forHuman];
        }
    }

    /**
     * @test
     * @dataProvider invalidMediaTypeProvider
     */
    public function it_requires_a_valid_media_type(string $input)
    {
        $this->expectException(InvalidArgumentException::class);

        new MediaType($input);
    }

    public function invalidMediaTypeProvider() : array
    {
        return [
            'no sub-type' => ['foo'],
            'spaces' => ['foo/ bar'],
            'missing parameters' => ['foo/bar;'],
        ];
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\MediaSource;
use eLife\Patterns\ViewModel\MediaSourceFallback;
use eLife\Patterns\ViewModel\MediaType;
use eLife\Patterns\ViewModel\Video;
use InvalidArgumentException;

final class VideoTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'posterFrame' => 'http://some.image.com/test.jpg',
            'sources' => [
                [
                    'src' => '/file.mp4',
                    'mediaType' => [
                        'forMachine' => 'video/mp4',
                        'forHuman' => 'MPEG-4',
                    ],
                    'fallback' => [
                        'content' => 'fallback',
                        'isExternal' => true,
                    ],
                ],
            ],
            'autoplay' => true,
            'loop' => true,
        ];
        $video = new Video(array_map(function ($source) {
            return new MediaSource(
                $source['src'],
                new MediaType($source['mediaType']['forMachine']),
                new MediaSourceFallback('fallback', true)
            );
        }, $data['sources']), $data['posterFrame'], $data['autoplay'], $data['loop']);

        $this->assertSameWithoutOrder($data, $video->toArray());
    }

    /**
     * @test
     */
    public function testCantUseAudioAsVideoSource()
    {
        $this->expectException(InvalidArgumentException::class);
        new Video([new MediaSource('/file.mp4', new MediaType('audio/mp4'))]);
    }

    /**
     * @test
     */
    public function testCantUseAudioSource()
    {
        $this->expectException(InvalidArgumentException::class);
        new Video([new MediaSource('/file.mp3', new MediaType('audio/mp3'))]);
    }

    public function viewModelProvider(): array
    {
        return [
            'complete' => [
                new Video([new MediaSource('/file.mp4', new MediaType('video/mp4'), new MediaSourceFallback('fallback', true))], 'http://some.image.com/test.jpg', true, true),
            ],
            'minimum' => [
                new Video([new MediaSource('/file.mp4', new MediaType('video/mp4'))]),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/video.mustache';
    }
}

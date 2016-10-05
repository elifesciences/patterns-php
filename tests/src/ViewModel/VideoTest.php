<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\MediaSource;
use eLife\Patterns\ViewModel\MimeType;
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
                        'mimeType' => [
                                'forMachine' => 'video/mp4',
                                'forHuman' => 'MP4',
                            ],
                    ],
                ],
        ];
        $video = new Video($data['posterFrame'], array_map(function ($source) {
            return new MediaSource($source['src'], new MimeType($source['mimeType']['forMachine'], $source['mimeType']['forHuman']));
        }, $data['sources']));

        $this->assertSameWithoutOrder($data, $video->toArray());
    }

    /**
     * @test
     */
    public function testCantUseAudioAsVideoSource()
    {
        $this->expectException(InvalidArgumentException::class);
        new Video('http://some.image.com/test.jpg', [MediaSource::videoSource('/file.mp4', 'audio/mp4')]);
    }

    /**
     * @test
     */
    public function testCantUseAudioSource()
    {
        $this->expectException(InvalidArgumentException::class);
        new Video('http://some.image.com/test.jpg', [MediaSource::audioSource('/file.mp3', 'audio/mp3')]);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new Video('http://some.image.com/test.jpg', [new MediaSource('/file.mp4', new MimeType('video/mp4', 'MP4'))]),
            ],
            [
                new Video('http://some.image.com/test.jpg', [MediaSource::videoSource('/file.mp4', 'video/mp4')]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/video.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;


use eLife\Patterns\ViewModel\MediaSource;
use eLife\Patterns\ViewModel\MediaSourceFallback;
use eLife\Patterns\ViewModel\MimeType;

final class MediaSourceTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'src' => 'http://google.com/test.mp3',
            'mimeType' =>
                [
                    'forMachine' => 'audio/mp3',
                    'forHuman' => 'MP3',
                ],
            'fallback' =>
                [
                    'content' => 'Download me',
                    'isExternal' => true,
                    'classes' => 'test-class',
                ],
        ];
        $mediaSource = new MediaSource(
            $data['src'],
            new MimeType($data['mimeType']['forMachine'], $data['mimeType']['forHuman']),
            new MediaSourceFallback($data['fallback']['content'], $data['fallback']['isExternal'], explode(' ', $data['fallback']['classes']))
        );

        $this->assertSameValuesWithoutOrder($mediaSource, $data);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new MediaSource(
                    'http://google.com/test.mp3',
                    new MimeType('audio/mp3', 'MP3'),
                    new MediaSourceFallback('Download me', true, ['test-class'])
                )
            ],
            [
                new MediaSource(
                    'http://google.com/test.mp3',
                    new MimeType('audio/mp3', 'MP3')
                )
            ],
            [
                new MediaSource(
                    'http://google.com/test.mp4',
                    new MimeType('video/mp4', 'Video')
                )
            ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/media-source.mustache';
    }
}

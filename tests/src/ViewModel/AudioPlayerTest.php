<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AudioPlayer;
use eLife\Patterns\ViewModel\AudioSource;
use InvalidArgumentException;

class AudioPlayerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_should_not_accept_unknown_type()
    {
        $this->expectException(InvalidArgumentException::class);
        new AudioPlayer('this will fail', [new AudioSource('/nope.jpg', 'jpg')]);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title of player',
            'sources' => [
                [
                    'mimeType' => AudioSource::TYPE_MP3,
                    'src' => '/audio.mp3',
                ],
                [
                    'mimeType' => AudioSource::TYPE_OGG,
                    'src' => '/audio.ogg',
                ]
            ],
        ];

        $audioPlayer = new AudioPlayer($data['title'], [
            new AudioSource($data['sources'][0]['src'], $data['sources'][0]['mimeType']),
        ]);
        $audioPlayer->addSource(new AudioSource($data['sources'][1]['src'], $data['sources'][1]['mimeType']));

        $this->assertSame($data['title'], $audioPlayer['title']);
        $this->assertSame($data['sources'][0], $audioPlayer['sources'][0]->toArray());
        $this->assertSame($data['sources'][0]['mimeType'], $audioPlayer['sources'][0]['mimeType']);
        $this->assertSame($data['sources'][0]['src'], $audioPlayer['sources'][0]['src']);
        $this->assertSame($data['sources'][1], $audioPlayer['sources'][1]->toArray());
        $this->assertSame($data['sources'][1]['mimeType'], $audioPlayer['sources'][1]['mimeType']);
        $this->assertSame($data['sources'][1]['src'], $audioPlayer['sources'][1]['src']);
        $this->assertSame($data, $audioPlayer->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new AudioPlayer('title of player', [
                    new AudioSource('/audio.mp3', AudioSource::TYPE_MP3),
                    new AudioSource('/audio.ogg',  AudioSource::TYPE_OGG),
                ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/audio-player.mustache';
    }
}

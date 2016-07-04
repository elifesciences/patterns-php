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
    public function it_should_not_accept_unknown_type() {
        $this->expectException(InvalidArgumentException::class);
        new AudioPlayer('this will fail', [ new AudioSource('/nope.jpg','jpg') ]);
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
                    'mime_type' => 'audio/mp3',
                    'type' => 'mp3',
                    'src' => '/audio.mp3',
                ],
                [
                    'mime_type' => 'audio/ogg',
                    'type' => 'ogg',
                    'src' => '/ogg.mp3',
                ],
                [
                    'mime_type' => 'audio/webm',
                    'type' => 'webm',
                    'src' => '/webm.mp3',
                ],
            ],
        ];

        $audioPlayer = new AudioPlayer($data['title'], [
            new AudioSource($data['sources'][0]['src'], $data['sources'][0]['type']),
            new AudioSource($data['sources'][1]['src'], $data['sources'][1]['type'])
        ]);
        $audioPlayer->addSource(new AudioSource($data['sources'][2]['src'], $data['sources'][2]['type']));

        $this->assertSame($data['title'], $audioPlayer['title']);
        $this->assertSame($data['sources'][0], $audioPlayer['sources'][0]->toArray());
        $this->assertSame($data['sources'][0]['mime_type'], $audioPlayer['sources'][0]['mime_type']);
        $this->assertSame($data['sources'][0]['type'], $audioPlayer['sources'][0]['type']);
        $this->assertSame($data['sources'][0]['src'], $audioPlayer['sources'][0]['src']);
        $this->assertSame($data['sources'][1], $audioPlayer['sources'][1]->toArray());
        $this->assertSame($data['sources'][1]['mime_type'], $audioPlayer['sources'][1]['mime_type']);
        $this->assertSame($data['sources'][1]['type'], $audioPlayer['sources'][1]['type']);
        $this->assertSame($data['sources'][1]['src'], $audioPlayer['sources'][1]['src']);
        $this->assertSame($data['sources'][2], $audioPlayer['sources'][2]->toArray());
        $this->assertSame($data['sources'][2]['mime_type'], $audioPlayer['sources'][2]['mime_type']);
        $this->assertSame($data['sources'][2]['type'], $audioPlayer['sources'][2]['type']);
        $this->assertSame($data['sources'][2]['src'], $audioPlayer['sources'][2]['src']);
        $this->assertSame($data, $audioPlayer->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new AudioPlayer('title of player', [
                    new AudioSource('/audio.mp3', 'mp3'),
                    new AudioSource('/ogg.mp3', 'ogg'),
                    new AudioSource('/webm.mp3', 'webm'),
                ])
            ]
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/audio-player.mustache';
    }
}

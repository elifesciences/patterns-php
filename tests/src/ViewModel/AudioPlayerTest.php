<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AudioPlayer;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MediaChapterListingItem;
use eLife\Patterns\ViewModel\MediaSource;
use eLife\Patterns\ViewModel\MediaSourceFallback;
use eLife\Patterns\ViewModel\MediaType;
use InvalidArgumentException;

final class AudioPlayerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_should_not_accept_unknown_type()
    {
        $this->expectException(InvalidArgumentException::class);
        new AudioPlayer(
            1,
            new Link('this will fail'),
            [
                new MediaSource('/nope.jpg', new MediaType('image/jpeg')),
            ],
            [
                new MediaChapterListingItem('chapter 1', 0, 1),
            ]
        );
    }

    /**
     * @test
     */
    public function it_should_not_accept_video_type()
    {
        $this->expectException(InvalidArgumentException::class);
        new AudioPlayer(
            1,
            new Link('this will fail'),
            [
                new MediaSource('/nope.jpg', new MediaType('video/mp4')),
            ],
            [
                new MediaChapterListingItem('chapter 1', 0, 1),
            ]
        );
    }

    /**
     * @test
     */
    public function it_requires_a_positive_episode_number()
    {
        $this->expectException(InvalidArgumentException::class);
        new AudioPlayer(
            0,
            new Link('this will fail'),
            [
                new MediaSource('/nope.mp3', new MediaType('audio/mpeg')),
            ],
            [
                new MediaChapterListingItem('chapter 1', 0, 1),
            ]
        );
    }

    /**
     * @test
     */
    public function it_requires_at_least_one_chapter()
    {
        $this->expectException(InvalidArgumentException::class);
        new AudioPlayer(
            1,
            new Link('this will fail'),
            [
                new MediaSource('/nope.mp3', new MediaType('audio/mpeg')),
            ],
            []
        );
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $chapters = [
            ['number' => 1, 'title' => 'Chapter 1', 'time' => 10],
            ['number' => 2, 'title' => 'Chapter 2', 'time' => 25],
        ];
        $data = [
            'episodeNumber' => 1,
            'title' => 'title of player',
            'url' => 'url',
            'sources' => [
                [
                    'mediaType' => [
                        'forMachine' => 'audio/mpeg',
                        'forHuman' => 'MPEG',
                    ],
                    'src' => '/audio.mp3',
                    'fallback' => [
                        'content' => 'fallback',
                        'isExternal' => true,
                        'classes' => 'media-source__fallback_link--audio-player',
                    ],
                ],
                [
                    'mediaType' => [
                        'forMachine' => 'audio/ogg',
                        'forHuman' => 'Ogg',
                    ],
                    'src' => '/audio.ogg',
                ],
            ],
            'metadata' => str_replace('"', '\'', json_encode(['number' => 1, 'chapters' => $chapters])),
        ];

        $audioPlayer = new AudioPlayer($data['episodeNumber'], new Link($data['title'], $data['url']),
            [
                new MediaSource($data['sources'][0]['src'],
                    new MediaType($data['sources'][0]['mediaType']['forMachine']),
                    new MediaSourceFallback('fallback', true)),
                new MediaSource($data['sources'][1]['src'],
                    new MediaType($data['sources'][1]['mediaType']['forMachine'])),
            ],
            [
                new MediaChapterListingItem($chapters[0]['title'], $chapters[0]['time'],
                    $chapters[0]['number']),
                new MediaChapterListingItem($chapters[1]['title'], $chapters[1]['time'],
                    $chapters[1]['number']),
            ]
        );

        $this->assertSame($data['episodeNumber'], $audioPlayer['episodeNumber']);
        $this->assertSame($data['title'], $audioPlayer['title']);
        $this->assertSame($data['url'], $audioPlayer['url']);
        $this->assertSameWithoutOrder($data['sources'][0], $audioPlayer['sources'][0]);
        $this->assertSameWithoutOrder($data['sources'][0]['mediaType'], $audioPlayer['sources'][0]['mediaType']);
        $this->assertSame($data['sources'][0]['src'], $audioPlayer['sources'][0]['src']);
        $this->assertSameWithoutOrder($data['sources'][1], $audioPlayer['sources'][1]);
        $this->assertSameWithoutOrder($data['sources'][1]['mediaType'], $audioPlayer['sources'][1]['mediaType']);
        $this->assertSame($data['sources'][1]['src'], $audioPlayer['sources'][1]['src']);
        $this->assertSame($data['metadata'], $audioPlayer['metadata']);
        $this->assertSameWithoutOrder($data, $audioPlayer);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new AudioPlayer(1, new Link('title of player', 'url'),
                    [
                        new MediaSource('/audio.mp3', new MediaType('audio/mpeg'),
                            new MediaSourceFallback('fallback', true)),
                        new MediaSource('/audio.ogg', new MediaType('audio/ogg')),
                    ],
                    [
                        new MediaChapterListingItem('chapter 1', 0, 1),
                    ]
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/audio-player.mustache';
    }
}

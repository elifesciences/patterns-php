<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentSource;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MediaChapterListingItem;
use InvalidArgumentException;

final class MediaChapterListingItemTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title',
            'startTime' => [
                'forMachine' => 333,
                'forHuman' => '5:33',
            ],
            'chapterNumber' => 1,
            'content' => 'content',
            'hasContentSources' => true,
            'contentSources' => [
                [
                    'contentType' => [
                        'name' => 'content type',
                        'url' => 'url',
                    ],
                    'text' => 'text',
                ],
            ],
        ];

        $item = new MediaChapterListingItem($data['title'], $data['startTime']['forMachine'], $data['chapterNumber'],
            $data['content'], array_map(function (array $contentSource) {
                return new ContentSource(new Link($contentSource['contentType']['name'], $contentSource['contentType']['url']), $contentSource['text']);
            }, $data['contentSources']));

        $this->assertSame($data['title'], $item['title']);
        $this->assertSame($data['startTime'], $item['startTime']);
        $this->assertSame($data['chapterNumber'], $item['chapterNumber']);
        $this->assertSame($data['content'], $item['content']);
        $this->assertSame($data['hasContentSources'], $item['hasContentSources']);
        $this->assertSameWithoutOrder($data['contentSources'], $item['contentSources']);
        $this->assertSame($data, $item->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new MediaChapterListingItem('', 0, 1);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_negative_start_time()
    {
        $this->expectException(InvalidArgumentException::class);

        new MediaChapterListingItem('title', -1, 1);
    }

    /**
     * @test
     */
    public function it_must_have_a_positive_chapter_number()
    {
        $this->expectException(InvalidArgumentException::class);

        new MediaChapterListingItem('title', 0, 0);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new MediaChapterListingItem('title', 0, 1)],
            'complete' => [new MediaChapterListingItem('title', 0, 1, 'foo', [new ContentSource(new Link('name', 'url'), 'text')])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/media-chapter-listing-item.mustache';
    }
}

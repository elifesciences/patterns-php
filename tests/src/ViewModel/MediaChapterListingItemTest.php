<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\MediaChapterListingItem;
use eLife\Patterns\ViewModel\Meta;
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
            'meta' => [
                'text' => 'meta',
            ],
        ];

        $item = new MediaChapterListingItem($data['title'], $data['startTime']['forMachine'], $data['chapterNumber'],
            $data['content'], Meta::withText($data['meta']['text']));

        $this->assertSame($data['title'], $item['title']);
        $this->assertSame($data['startTime'], $item['startTime']);
        $this->assertSame($data['chapterNumber'], $item['chapterNumber']);
        $this->assertSame($data['content'], $item['content']);
        $this->assertEquals($data['meta'], $item['meta']->toArray());
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
            'complete' => [new MediaChapterListingItem('title', 0, 1, 'foo', Meta::withText('bar'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/media-chapter-listing-item.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderReadMore;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListHeading;
use eLife\Patterns\ViewModel\ListingReadMore;
use eLife\Patterns\ViewModel\Pager;
use eLife\Patterns\ViewModel\ReadMoreItem;
use eLife\Patterns\ViewModel\SeeMoreLink;

final class ListingReadMoreTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'items' => [
                [
                    'item' => [
                        'title' => 'title a',
                        'url' => '#',
                    ],
                    'content' => 'With extra content',
                    'isRelated' => true,
                ],
                [
                    'item' => [
                        'title' => 'title b',
                        'url' => '#',
                    ],
                ],
                [
                    'item' => [
                        'title' => 'title c',
                        'url' => '#',
                    ],
                ],
            ],
        ];

        $list = array_map(function ($item) {
            return new ReadMoreItem(
                new ContentHeaderReadMore($item['item']['title'], $item['item']['url']),
                $item['content'] ?? null,
                $item['isRelated'] ?? false);
        }, $data['items']);

        $listingReadMore = ListingReadMore::basic($list);

        $this->assertSameWithoutOrder($data, $listingReadMore->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                ListingReadMore::basic([
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#'), 'some extra content'),
                ]),
            ],
            [
                ListingReadMore::basic([
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#'), 'some extra content'),
                ], new ListHeading('heading'), 'id'),
            ],
            [
                ListingReadMore::basic([
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#'), 'some extra content'),
                    new ReadMoreItem(new ContentHeaderReadMore('title', '#'), 'some extra content', true),
                ], new ListHeading('heading'), 'id'),
            ],
            [
                ListingReadMore::withPagination(
                    [
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    ],
                    Pager::firstPage(new Link('testing', '#')),
                    new ListHeading('heading'), 'id'
                ),
            ],
            [
                ListingReadMore::withPagination(
                    [
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    ],
                    Pager::subsequentPage(new Link('previous', 'previous-url'), new Link('next', 'next-url')),
                    new ListHeading('heading')
                ),
            ],
            [
                ListingReadMore::withSeeMore(
                    [
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                        new ReadMoreItem(new ContentHeaderReadMore('title', '#')),
                    ],
                    new SeeMoreLink(new Link('testing', '#')),
                    new ListHeading('heading'), 'id'
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/listing-read-more.mustache';
    }
}

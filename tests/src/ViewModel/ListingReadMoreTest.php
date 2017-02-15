<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderArticle;
use eLife\Patterns\ViewModel\ContentHeaderReadMore;
use eLife\Patterns\ViewModel\Link;
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
                                'behaviour' => 'ContentHeaderArticle',
                                'title' => 'title a',
                                'titleClass' => 'content-header__title--large',
                            ],
                        'content' => 'With extra content',
                    ],
                    [
                        'item' => [
                                'behaviour' => 'ContentHeaderArticle',
                                'title' => 'title b',
                                'titleClass' => 'content-header__title--large',
                            ],
                    ],
                    [
                        'item' => [
                                'behaviour' => 'ContentHeaderArticle',
                                'title' => 'title c',
                                'titleClass' => 'content-header__title--large',
                            ],
                    ],
                ],
        ];

        $list = array_map(function ($item) {
            return new ReadMoreItem(new ContentHeaderReadMore($item['item']['title']), $item['content'] ?? null);
        }, $data['items']);

        $listingReadMore = ListingReadMore::basic($list);

        $this->assertSameWithoutOrder($data, $listingReadMore->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            [
                ListingReadMore::basic([
                    new ReadMoreItem(new ContentHeaderReadMore('title')),
                    new ReadMoreItem(new ContentHeaderReadMore('title')),
                    new ReadMoreItem(new ContentHeaderReadMore('title'), 'some extra content'),
                ]),
            ],
            [
                ListingReadMore::basic([
                    new ReadMoreItem(new ContentHeaderReadMore('title')),
                    new ReadMoreItem(new ContentHeaderReadMore('title')),
                    new ReadMoreItem(new ContentHeaderReadMore('title'), 'some extra content'),
                ], 'heading', 'id'),
            ],
            [
                ListingReadMore::withPagination(
                    [
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                    ],
                    Pager::firstPage(new Link('testing', '#')),
                    'heading', 'id'
                ),
            ],
            [
                ListingReadMore::withPagination(
                    [
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                    ],
                    Pager::subsequentPage(new Link('previous', 'previous-url'), new Link('next', 'next-url')),
                    'heading'
                ),
            ],
            [
                ListingReadMore::withSeeMore(
                    [
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                        new ReadMoreItem(new ContentHeaderReadMore('title')),
                    ],
                    new SeeMoreLink(new Link('testing', '#')),
                    'heading', 'id'
                ),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return '/elife/patterns/templates/listing-read-more.mustache';
    }
}

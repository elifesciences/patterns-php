<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListingTeasers;
use eLife\Patterns\ViewModel\LoadMore;
use eLife\Patterns\ViewModel\Pager;
use eLife\Patterns\ViewModel\SeeMoreLink;
use eLife\Patterns\ViewModel\Teaser;
use InvalidArgumentException;

final class ListingTeasersTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'items' => [
                [
                    'title' => 'title',
                    'rootClasses' => 'teaser--secondary',
                    'url' => 'url',
                ],
                [
                    'title' => 'title',
                    'rootClasses' => 'teaser--secondary',
                    'url' => 'url',
                ],
                [
                    'title' => 'title',
                    'rootClasses' => 'teaser--secondary',
                    'url' => 'url',
                ],
            ],
        ];
        $listingTeaser = ListingTeasers::basic(
            array_map(function ($item) {
                return Teaser::basic($item['title'], $item['url']);
            }, $data['items'])
        );

        $this->assertSameWithoutOrder($data, $listingTeaser->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_no_teasers()
    {
        $this->expectException(InvalidArgumentException::class);

        ListingTeasers::basic([]);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                ListingTeasers::basic([
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url'),
                ]),
            ],
            [
                ListingTeasers::basic([
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url'),
                ], 'heading'),
            ],
            [
                ListingTeasers::withPagination(
                    [
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                    ],
                    new LoadMore(new Link('testing', '#')),
                    'heading'
                ),
            ],
            [
                ListingTeasers::withPagination(
                    [
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                    ],
                    new Pager(new Link('previous', 'previous-url'), new Link('next', 'next-url')),
                    'heading'
                ),
            ],
            [
                ListingTeasers::withSeeMore(
                    [
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                    ],
                    new SeeMoreLink(new Link('testing', '#')),
                    'heading'
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/listing-teasers.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListingTeasers;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Pager;
use eLife\Patterns\ViewModel\SeeMoreLink;
use eLife\Patterns\ViewModel\Teaser;
use eLife\Patterns\ViewModel\TeaserFooter;
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

        $data = [
            'items' => [
                [
                    'carouselItem' => true,
                    'num' => 1,
                    'title' => 'title',
                    'rootClasses' => 'teaser--secondary teaser--highlights',
                    'url' => 'url',
                    'secondaryInfo' => 'Author et al',
                    'footer' => [
                        'meta' => [
                            'url' => '#',
                            'text' => 'meta',
                        ],
                    ],
                ],
                [
                    'carouselItem' => true,
                    'num' => 2,
                    'title' => 'title',
                    'rootClasses' => 'teaser--secondary teaser--highlights',
                    'url' => 'url',
                ],
                [
                    'carouselItem' => true,
                    'num' => 3,
                    'title' => 'title',
                    'rootClasses' => 'teaser--secondary teaser--highlights',
                    'url' => 'url',
                ],
            ],
            'heading' => 'Highlights',
            'id' => 'highlights',
            'headingId' => 'highlights-heading',
            'highlights' => true,
        ];
        $listingTeaser = ListingTeasers::forHighlights(
            array_map(function (array $item) {
                if (!empty($item['footer'])) {
                    $footer = TeaserFooter::forNonArticle(Meta::withLink(new Link($item['footer']['meta']['text'], $item['footer']['meta']['url'])));
                }

                return Teaser::secondary($item['title'], $item['url'], $item['secondaryInfo'] ?? null, null, null, $footer ?? null);
            }, $data['items']), $data['heading'], $data['id']);

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
                ], 'heading', 'id'),
            ],
            [
                ListingTeasers::withPagination(
                    [
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                    ],
                    Pager::firstPage(new Link('testing', '#')),
                    'heading', 'id'
                ),
            ],
            [
                ListingTeasers::withPagination(
                    [
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                        Teaser::basic('title', 'url'),
                    ],
                    Pager::subsequentPage(new Link('previous', 'previous-url'), new Link('next', 'next-url')),
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
                    'heading', 'id'
                ),
            ],
            [
                ListingTeasers::forHighlights(
                    [
                        Teaser::secondary('title', 'url'),
                        Teaser::secondary('title', 'url'),
                        Teaser::secondary('title', 'url'),
                    ],
                    'heading', 'id'
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/listing-teasers.mustache';
    }
}

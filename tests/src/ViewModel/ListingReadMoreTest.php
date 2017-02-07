<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderArticle;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListingReadMore;
use eLife\Patterns\ViewModel\Pager;
use eLife\Patterns\ViewModel\SeeMoreLink;

/**
 * @group test
 */
class ListingReadMoreTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'items' => [
                [
                    'rootClasses' => 'content-header-article content-header-article-magazine',
                    'behaviour' => 'ContentHeaderArticle',
                    'title' => 'title a',
                    'titleClass' => 'content-header__title--large',
                ],
                [
                    'rootClasses' => 'content-header-article content-header-article-magazine',
                    'behaviour' => 'ContentHeaderArticle',
                    'title' => 'title b',
                    'titleClass' => 'content-header__title--large',
                ],
                [
                    'rootClasses' => 'content-header-article content-header-article-magazine',
                    'behaviour' => 'ContentHeaderArticle',
                    'title' => 'title c',
                    'titleClass' => 'content-header__title--large',
                ],
            ],
        ];

        $list = array_map(function ($item) {
            return ContentHeaderArticle::magazine($item['title']);
        }, $data['items']);

        $listingReadMore = new ListingReadMore($list);

        $this->assertSameWithoutOrder($data, $listingReadMore->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            [
                ListingReadMore::basic([
                    ContentHeaderArticle::magazine('title'),
                    ContentHeaderArticle::magazine('title'),
                    ContentHeaderArticle::magazine('title'),
                ]),
            ],
            [
                ListingReadMore::basic([
                    ContentHeaderArticle::magazine('title'),
                    ContentHeaderArticle::magazine('title'),
                    ContentHeaderArticle::magazine('title'),
                ], 'heading', 'id'),
            ],
            [
                ListingReadMore::withPagination(
                    [
                        ContentHeaderArticle::magazine('title'),
                        ContentHeaderArticle::magazine('title'),
                        ContentHeaderArticle::magazine('title'),
                    ],
                    Pager::firstPage(new Link('testing', '#')),
                    'heading', 'id'
                ),
            ],
            [
                ListingReadMore::withPagination(
                    [
                        ContentHeaderArticle::magazine('title'),
                        ContentHeaderArticle::magazine('title'),
                        ContentHeaderArticle::magazine('title'),
                    ],
                    Pager::subsequentPage(new Link('previous', 'previous-url'), new Link('next', 'next-url')),
                    'heading'
                ),
            ],
            [
                ListingReadMore::withSeeMore(
                    [
                        ContentHeaderArticle::magazine('title'),
                        ContentHeaderArticle::magazine('title'),
                        ContentHeaderArticle::magazine('title'),
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

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ListingTeasers;
use eLife\Patterns\ViewModel\LoadMoreButton;
use eLife\Patterns\ViewModel\Teaser;

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
            ...array_map(function ($item) {
                return Teaser::basic($item['title'], $item['url']);
            }, $data['items'])
        );

        $this->assertSameWithoutOrder($data, $listingTeaser->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                ListingTeasers::basic(
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url')
                ),
            ],
            [
                ListingTeasers::withHeading(
                    'heading',
                    null,
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url')
                ),
            ],
            [
                ListingTeasers::withHeading(
                    'heading',
                    new LoadMoreButton('testing', '#'),
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url')
                ),
            ],
            [
                ListingTeasers::withoutHeading(
                    new LoadMoreButton('testing', '#'),
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url'),
                    Teaser::basic('title', 'url')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/listing-teasers.mustache';
    }
}

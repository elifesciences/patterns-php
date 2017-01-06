<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\ArchiveNavLink;
use eLife\Patterns\ViewModel\BackgroundImage;
use eLife\Patterns\ViewModel\BlockLink;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\GridListing;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Pager;
use eLife\Patterns\ViewModel\Teaser;
use eLife\Patterns\ViewModel\TeaserFooter;
use eLife\Patterns\ViewModel\TeaserImage;
use InvalidArgumentException;

final class GridListingTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $blockLinksData = [
            'classes' => 'grid-listing--block-link',
            'heading' => 'heading',
            'blockLinks' => [
                [
                    'text' => 'text',
                    'url' => 'url',
                    'behaviour' => 'BackgroundImage',
                    'backgroundImage' => [
                        'lowResImageSource' => 'lores.jpg',
                        'highResImageSource' => 'hires.jpg',
                        'thresholdWidth' => 100,
                    ],
                    'variant' => 'grid-listing',
                ],
            ],
        ];
        $blockLinks = GridListing::forBlockLinks([
            new BlockLink(new Link('text', 'url'), new BackgroundImage('lores.jpg', 'hires.jpg', 100)),
        ], 'heading');

        $this->assertSame($blockLinksData['classes'], $blockLinks['classes']);
        $this->assertSame($blockLinksData['heading'], $blockLinks['heading']);
        $this->assertCount(1, $blockLinksData['blockLinks']);
        $this->assertSame($blockLinksData['blockLinks'][0], $blockLinks['blockLinks'][0]->toArray());
        $this->assertSame($blockLinksData, $blockLinks->toArray());

        $archiveNavLinksData = [
            'heading' => 'heading',
            'archiveNavLinks' => [
                [
                    'blockLink' => [
                        'text' => 'text',
                        'url' => 'url',
                        'behaviour' => 'BackgroundImage',
                        'backgroundImage' => [
                            'lowResImageSource' => 'lores.jpg',
                            'highResImageSource' => 'hires.jpg',
                            'thresholdWidth' => 100,
                        ],
                    ],
                    'label' => 'label',
                    'links' => [
                        [
                            'name' => 'name',
                            'url' => 'url',
                        ],
                    ],
                ],
            ],
        ];
        $archiveNavLinks = GridListing::forArchiveNavLinks([
            new ArchiveNavLink(new BlockLink(new Link('text', 'url'),
                new BackgroundImage('lores.jpg', 'hires.jpg', 100)), 'label', [new Link('name', 'url')]),
        ], 'heading');

        $this->assertSame($archiveNavLinksData['heading'], $archiveNavLinks['heading']);
        $this->assertCount(1, $archiveNavLinksData['archiveNavLinks']);
        $this->assertSame($archiveNavLinksData['archiveNavLinks'][0],
            $archiveNavLinks['archiveNavLinks'][0]->toArray());
        $this->assertSame($archiveNavLinksData, $archiveNavLinks->toArray());

        $date = new DateTimeImmutable();

        $teasersData = [
            'heading' => 'heading',
            'teasers' => [
                [
                    'title' => 'title',
                    'rootClasses' => 'teaser--grid-style',
                    'url' => 'url',
                    'content' => 'content',
                    'secondaryInfo' => 'secondary info',
                    'image' => [
                        'defaultPath' => '250.jpg',
                        'altText' => 'alt',
                        'srcset' => '500.jpg 500w, 250.jpg 250w',
                        'classes' => 'teaser__img--prominent',
                    ],
                    'footer' => [
                        'meta' => [
                            'url' => 'path',
                            'text' => 'name',
                            'date' => [
                                'isExpanded' => false,
                                'isUpdated' => false,
                                'forHuman' => [
                                    'dayOfMonth' => (int) $date->format('j'),
                                    'month' => $date->format('M'),
                                    'year' => (int) $date->format('Y'),
                                ],
                                'forMachine' => $date->format('Y-m-d'),
                            ],

                        ],
                    ],
                ],
            ],
        ];
        $teasers = GridListing::forTeasers(
            [
                Teaser::withGrid(
                    'title',
                    'url',
                    'content',
                    'secondary info',
                    TeaserImage::prominent(
                        '250.jpg',
                        'alt',
                        [
                            500 => '500.jpg',
                            250 => '250.jpg',
                        ]
                    ),
                    TeaserFooter::forNonArticle(
                        Meta::withLink(
                            new Link('name', 'path'),
                            Date::simple($date)
                        )
                    )
                ),
            ],
            'heading');

        $this->assertSame($teasersData['heading'], $teasers['heading']);
        $this->assertCount(1, $teasersData['teasers']);
        $this->assertSame($teasersData['teasers'][0], $teasers['teasers'][0]->toArray());
        $this->assertSame($teasersData, $teasers->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'no heading' => [
                GridListing::forBlockLinks([new BlockLink(new Link('text', 'url'))]),
            ],
            'block links' => [
                GridListing::forBlockLinks(
                    [
                        new BlockLink(new Link('text', 'url')),
                        new BlockLink(new Link('text', 'url'), new BackgroundImage('lores.jpg', 'hires.jpg', 100)),
                    ],
                    'heading'),
            ],
            'archive nav links' => [
                GridListing::forArchiveNavLinks(
                    [
                        new ArchiveNavLink(new BlockLink(new Link('text', 'url')), 'label', [new Link('text', 'url')]),
                        new ArchiveNavLink(new BlockLink(new Link('text', 'url'),
                            new BackgroundImage('lores.jpg', 'hires.jpg', 100)), 'label', [new Link('text', 'url')]),
                    ],
                    'heading'),
            ],
            'teasers' => [
                GridListing::forTeasers(
                    [
                        Teaser::withGrid(
                            'title',
                            'url',
                            'content',
                            'secondary info',
                            TeaserImage::prominent(
                                '250.jpg',
                                'alt',
                                [
                                    500 => '500.jpg',
                                    250 => '250.jpg',
                                ]
                            ),
                            TeaserFooter::forNonArticle(
                                Meta::withLink(
                                    new Link('name', 'path'),
                                    Date::simple(new DateTimeImmutable())
                                )
                            )
                        ),
                    ],
                    'heading'),
            ],
            'teasers with load more' => [
                GridListing::forTeasers(
                    [
                        Teaser::withGrid(
                            'title',
                            'url',
                            'content',
                            'secondary info',
                            TeaserImage::prominent(
                                '250.jpg',
                                'alt',
                                [
                                    500 => '500.jpg',
                                    250 => '250.jpg',
                                ]
                            ),
                            TeaserFooter::forNonArticle(
                                Meta::withLink(
                                    new Link('name', 'path'),
                                    Date::simple(new DateTimeImmutable())
                                )
                            )
                        ),
                    ],
                    'heading', Pager::firstPage(new Link('testing', '#'))),
            ],
            'teasers with pager' => [
                GridListing::forTeasers(
                    [
                        Teaser::withGrid(
                            'title',
                            'url',
                            'content',
                            'secondary info',
                            TeaserImage::prominent(
                                '250.jpg',
                                'alt',
                                [
                                    500 => '500.jpg',
                                    250 => '250.jpg',
                                ]
                            ),
                            TeaserFooter::forNonArticle(
                                Meta::withLink(
                                    new Link('name', 'path'),
                                    Date::simple(new DateTimeImmutable())
                                )
                            )
                        ),
                    ],
                    'heading', Pager::subsequentPage(new Link('previous', 'previous-url'), new Link('next', 'next-url'))),
            ],
        ];
    }

    /**
     * @test
     */
    public function it_cannot_have_no_block_links()
    {
        $this->expectException(InvalidArgumentException::class);

        GridListing::forBlockLinks([]);
    }

    /**
     * @test
     */
    public function it_must_have_only_block_links()
    {
        $this->expectException(InvalidArgumentException::class);

        GridListing::forBlockLinks(['foo']);
    }

    /**
     * @test
     */
    public function it_cannot_have_no_archive_nav_links()
    {
        $this->expectException(InvalidArgumentException::class);

        GridListing::forArchiveNavLinks([]);
    }

    /**
     * @test
     */
    public function it_must_have_only_archive_nav_links()
    {
        $this->expectException(InvalidArgumentException::class);

        GridListing::forArchiveNavLinks(['foo']);
    }

    /**
     * @test
     */
    public function it_cannot_have_no_teasers()
    {
        $this->expectException(InvalidArgumentException::class);

        GridListing::forTeasers([]);
    }

    /**
     * @test
     */
    public function it_must_have_only_teasers()
    {
        $this->expectException(InvalidArgumentException::class);

        GridListing::forTeasers(['foo']);
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/grid-listing.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use eLife\Patterns\ViewModel\AnnotationTeaser;
use eLife\Patterns\ViewModel\Date;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListHeading;
use eLife\Patterns\ViewModel\ListingAnnotationTeasers;
use eLife\Patterns\ViewModel\Pager;
use InvalidArgumentException;

final class ListingAnnotationTeasersTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'items' => [
                [
                    'document' => 'the document',
                    'highlight' => 'this highlight',
                    'content' => 'the content',
                    'meta' => [
                        'date' => [
                            'isExpanded' => false,
                            'isUpdated' => false,
                            'forHuman' => [
                                'dayOfMonth' => 21,
                                'month' => 'Dec',
                                'year' => 2017,
                            ],
                            'forMachine' => '2017-12-21',
                        ],
                    ],
                    'inContextUri' => '#the-uri',
                ],
                [
                    'document' => 'the document',
                    'highlight' => 'this highlight',
                    'content' => 'the content',
                    'meta' => [
                        'date' => [
                            'isExpanded' => false,
                            'isUpdated' => false,
                            'forHuman' => [
                                'dayOfMonth' => 21,
                                'month' => 'Dec',
                                'year' => 2017,
                            ],
                            'forMachine' => '2017-12-21',
                        ],
                    ],
                    'inContextUri' => '#the-uri',
                ],
                [
                    'document' => 'the document',
                    'highlight' => 'this highlight',
                    'content' => 'the content',
                    'meta' => [
                        'date' => [
                            'isExpanded' => false,
                            'isUpdated' => false,
                            'forHuman' => [
                                'dayOfMonth' => 21,
                                'month' => 'Dec',
                                'year' => 2017,
                            ],
                            'forMachine' => '2017-12-21',
                        ],
                    ],
                    'inContextUri' => '#the-uri',
                ],
            ],
        ];
        $listingAnnotationTeasers = ListingAnnotationTeasers::basic(
            array_map(function ($item) {
                return AnnotationTeaser::forAnnotation(
                    $item['document'],
                    Date::simple(new DateTimeImmutable('2017-12-21')),
                    $item['inContextUri'],
                    $item['highlight'],
                    $item['content']
                );
            }, $data['items'])
        );

        $this->assertSameWithoutOrder($data, $listingAnnotationTeasers->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_no_teasers()
    {
        $this->expectException(InvalidArgumentException::class);

        ListingAnnotationTeasers::basic([]);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                ListingAnnotationTeasers::basic(
                    [
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                    ]
                ),
            ],
            [
                ListingAnnotationTeasers::withPagination(
                    [
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                    ],
                    Pager::firstPage(new Link('testing', '#')),
                    new ListHeading('heading'), 'id'
                ),
            ],
            [
                ListingAnnotationTeasers::withPagination(
                    [
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                        AnnotationTeaser::forPageNote('the document',
                            Date::simple(new DateTimeImmutable('2017-12-21')),
                            '#the-uri',
                            ' the content'
                        ),
                    ],
                    Pager::subsequentPage(new Link('previous', 'previous-url'), new Link('next', 'next-url')),
                    new ListHeading('heading')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/listing-annotation-teasers.mustache';
    }
}

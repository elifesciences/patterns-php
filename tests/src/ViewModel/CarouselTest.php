<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Carousel;
use eLife\Patterns\ViewModel\CarouselItem;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\ListHeading;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;
use InvalidArgumentException;

final class CarouselTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'heading' => [
                'heading' => 'heading',
                'headingId' => 'headingId',
            ],
            'items' => [
                [
                    'subjects' => [
                        'list' => [
                            [
                                'name' => 'subject',
                                'url' => 'subject-url',
                            ],
                        ],
                    ],
                    'title' => 'carousel item',
                    'titleLength' => 'xx-short',
                    'url' => 'carousel-item-url',
                    'button' => [
                        'classes' => 'button--small button--outline',
                        'path' => 'carousel-item-url',
                        'text' => 'button',
                    ],
                    'meta' => [
                        'url' => false,
                        'text' => 'meta',
                    ],
                    'image' => [
                        'fallback' => [
                            'altText' => '',
                            'defaultPath' => '/default/path',
                        ],
                    ],
                ],
            ],
        ];

        $carouselItem = new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new Picture([], new Image('/default/path')));
        $carousel = new Carousel([$carouselItem], new ListHeading('heading', 'headingId'), 'id');

        $this->assertSame($data, $carousel->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_item()
    {
        $this->expectException(InvalidArgumentException::class);

        new Carousel([], new ListHeading('heading'));
    }

    public function viewModelProvider() : array
    {
        return [
            [new Carousel([new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new Picture([], new Image('/default/path')))], new ListHeading('heading'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/carousel.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\BackgroundImage;
use eLife\Patterns\ViewModel\Carousel;
use eLife\Patterns\ViewModel\CarouselItem;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use InvalidArgumentException;

final class CarouselTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
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
                    'name' => 'carousel item',
                    'url' => 'carousel-item-url',
                    'button' => [
                        'classes' => 'button--default',
                        'path' => 'carousel-item-url',
                        'text' => 'button',
                    ],
                    'meta' => [
                        'text' => 'meta',
                    ],
                    'backgroundImage' => [
                        'lowResImageSource' => 'lores.jpg',
                        'highResImageSource' => 'hires.jpg',
                    ],
                ],
            ],
        ];

        $carouselItem = new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new BackgroundImage('lores.jpg', 'hires.jpg'));
        $carousel = new Carousel($carouselItem);

        $this->assertSame($data, $carousel->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_item()
    {
        $this->expectException(InvalidArgumentException::class);

        new Carousel();
    }

    public function viewModelProvider() : array
    {
        return [
            [new Carousel(new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new BackgroundImage('lores.jpg', 'hires.jpg')))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/carousel.mustache';
    }
}

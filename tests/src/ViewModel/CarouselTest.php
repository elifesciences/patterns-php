<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Carousel;
use eLife\Patterns\ViewModel\CarouselItem;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
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
            'heading' => 'heading',
            'headingId' => 'id',
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
                    'url' => 'carousel-item-url',
                    'button' => [
                        'classes' => 'button--small button--outline',
                        'path' => 'carousel-item-url',
                        'text' => 'button',
                    ],
                    'meta' => [
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
        $carousel = new Carousel([$carouselItem], 'heading', 'id');

        $this->assertSame($data, $carousel->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_item()
    {
        $this->expectException(InvalidArgumentException::class);

        new Carousel([], 'heading');
    }

    /**
     * @test
     */
    public function it_must_have_a_heading()
    {
        $this->expectException(InvalidArgumentException::class);

        new Carousel([new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new Picture([], new Image('/default/path')))], '');
    }

    public function viewModelProvider() : array
    {
        return [
            [new Carousel([new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new Picture([], new Image('/default/path')))], 'heading')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/carousel.mustache';
    }
}

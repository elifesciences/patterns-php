<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CarouselItem;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;

final class CarouselItemTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'subjects' => [
                'list' => [
                    [
                        'name' => 'subject',
                        'url' => 'subject-url',
                    ],
                ],
            ],
            'title' => 'carousel item with a long title',
            'longTitle' => true,
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
        ];

        $carouselItem = new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item with a long title', 'carousel-item-url'), 'button', Meta::withText('meta'), new Picture([], new Image('/default/path')));

        $this->assertSame($data['subjects']['list'][0], $carouselItem['subjects']['list'][0]->toArray());
        $this->assertSame($data['title'], $carouselItem['title']);
        $this->assertSame($data['longTitle'], $carouselItem['longTitle']);
        $this->assertSame($data['url'], $carouselItem['url']);
        $this->assertSame($data['button'], $carouselItem['button']->toArray());
        $this->assertSame($data['meta'], $carouselItem['meta']->toArray());
        $this->assertSame($data['image'], $carouselItem['image']->toArray());
        $this->assertSame($data, $carouselItem->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new Picture([], new Image('/default/path')))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/carousel-item.mustache';
    }
}

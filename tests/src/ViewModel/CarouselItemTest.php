<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\BackgroundImage;
use eLife\Patterns\ViewModel\CarouselItem;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;

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
                'thresholdWidth' => 100,
            ],
        ];

        $carouselItem = new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new BackgroundImage('lores.jpg', 'hires.jpg', 100));

        $this->assertSame($data['subjects']['list'][0], $carouselItem['subjects']['list'][0]->toArray());
        $this->assertSame($data['name'], $carouselItem['name']);
        $this->assertSame($data['url'], $carouselItem['url']);
        $this->assertSame($data['button'], $carouselItem['button']->toArray());
        $this->assertSame($data['meta'], $carouselItem['meta']->toArray());
        $this->assertSame($data['backgroundImage'], $carouselItem['backgroundImage']->toArray());
        $this->assertSame($data, $carouselItem->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new BackgroundImage('lores.jpg', 'hires.jpg'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/carousel-item.mustache';
    }
}

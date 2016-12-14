<?php

namespace tests\eLife\Patterns\ViewModel;

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
                'classes' => 'button--outline',
                'path' => 'carousel-item-url',
                'text' => 'button',
            ],
            'meta' => [
                'text' => 'meta',
            ],
        ];

        $carouselItem = new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'));

        $this->assertSame($data['subjects']['list'][0], $carouselItem['subjects']['list'][0]->toArray());
        $this->assertSame($data['name'], $carouselItem['name']);
        $this->assertSame($data['url'], $carouselItem['url']);
        $this->assertSame($data['button'], $carouselItem['button']->toArray());
        $this->assertSame($data['meta'], $carouselItem['meta']->toArray());
        $this->assertSame($data, $carouselItem->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/carousel-item.mustache';
    }
}

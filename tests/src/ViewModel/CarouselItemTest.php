<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\CarouselItem;
use eLife\Patterns\ViewModel\ContentHeaderImage;
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
            'titleLength' => 'x-short',
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
                'credit' => [
                    'text' => 'image credit',
                ],
                'creditOverlay' => true,
            ],
        ];

        $carouselItem = new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item with a long title', 'carousel-item-url'), 'button', Meta::withText('meta'), new ContentHeaderImage(new Picture([], new Image('/default/path')), 'image credit', true));

        $data['image']['credit']['elementId'] = $carouselItem['image']['credit']['elementId'];

        $this->assertSame($data['subjects']['list'][0], $carouselItem['subjects']['list'][0]->toArray());
        $this->assertSame($data['title'], $carouselItem['title']);
        $this->assertSame($data['titleLength'], $carouselItem['titleLength']);
        $this->assertSame($data['url'], $carouselItem['url']);
        $this->assertSame($data['button'], $carouselItem['button']->toArray());
        $this->assertSame($data['meta'], $carouselItem['meta']->toArray());
        $this->assertSameWithoutOrder($data['image'], $carouselItem['image']);
        $this->assertSame($data, $carouselItem->toArray());
    }

    /**
     * @test
     * @dataProvider titleLengthProvider
     */
    public function a_title_has_the_correct_designation_for_its_length(int $length, string $expected)
    {
        $title = str_repeat('é', $length);

        $carouselItem = new CarouselItem(
            [],
            new Link($title, 'carousel-item-url'),
            'button',
            Meta::withText('meta'),
            new ContentHeaderImage(new Picture([], new Image('/default/path')))
        );

        $this->assertSame($expected, $carouselItem['titleLength']);
    }

    public function titleLengthProvider() : array
    {
        return [
            [3, 'xx-short'],
            [19, 'xx-short'],
            [20, 'x-short'],
            [35, 'x-short'],
            [36, 'short'],
            [46, 'short'],
            [47, 'medium'],
            [57, 'medium'],
            [58, 'long'],
            [80, 'long'],
            [81, 'x-long'],
            [120, 'x-long'],
            [121, 'xx-long'],
            [500, 'xx-long'],
        ];
    }

    public function viewModelProvider() : array
    {
        return [
            [new CarouselItem([new Link('subject', 'subject-url')], new Link('carousel item', 'carousel-item-url'), 'button', Meta::withText('meta'), new ContentHeaderImage(new Picture([], new Image('/default/path')), 'image credit', true))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/carousel-item.mustache';
    }
}

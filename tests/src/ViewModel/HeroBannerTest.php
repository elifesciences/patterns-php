<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\HeroBanner;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;

final class HeroBannerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title',
            'titleLength' => 'short',
            'summary' => 'summary',
            'authors' => 'author line',
            'subjects' => [
                'list' => [
                    [
                        'name' => 'subject',
                        'url' => 'subject-url',
                    ],
                ],
            ],
            'image' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
            ],
            'url' => 'url',
            'meta' => [
                'url' => false,
                'text' => 'meta',
            ],
        ];

        $heroBanner = new HeroBanner(
            [new Link('subject', 'subject-url')],
            new Link('title', 'url'),
            Meta::withText('meta'),
            new Picture([], new Image('/default/path')),
            'summary',
            'author line'
        );
        $this->assertSame($data['subjects']['list'][0], $heroBanner['subjects']['list'][0]->toArray());
        $this->assertSame($data['title'], $heroBanner['title']);
        $this->assertSame($data['titleLength'], $heroBanner['titleLength']);
        $this->assertSame($data['url'], $heroBanner['url']);
        $this->assertSame($data['meta'], $heroBanner['meta']->toArray());
        $this->assertSame($data['image'], $heroBanner['image']->toArray());
        $this->assertSame($data['summary'], $heroBanner['summary']);
        $this->assertSame($data['authors'], $heroBanner['authors']);
        $this->assertSame($data, $heroBanner->toArray());
    }

    /**
     * @test
     * @dataProvider titleLengthProvider
     */
    public function a_title_has_the_correct_designation_for_its_length(int $length, string $expected)
    {
        $title = str_repeat('é', $length);

        $carouselItem = new HeroBanner(
            [],
            new Link($title, 'url'),
            Meta::withText('meta'),
            new Picture([], new Image('path/to/image'))
        );

        $this->assertSame($expected, $carouselItem['titleLength']);
    }

    public function titleLengthProvider() : array
    {
        return [
            [3, 'short'],
            [19, 'short'],
            [20, 'short'],
            [35, 'short'],
            [36, 'short'],
            [46, 'short'],
            [49, 'short'],
            [50, 'medium'],
            [58, 'medium'],
            [80, 'medium'],
            [89, 'medium'],
            [90, 'long'],
            [121, 'long'],
            [500, 'long'],
        ];
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new HeroBanner(
                [],
                new Link('link', 'url'),
                Meta::withText('meta'),
                new Picture([], new Image('path/to/image'))
            )],
            'complete' => [new HeroBanner(
                [new Link('subject', 'subject-url')],
                new Link('link', 'url'),
                Meta::withText('meta'),
                new Picture([], new Image('path/to/image')),
                'summary',
                'author line'
            )],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/hero-banner.mustache';
    }
}

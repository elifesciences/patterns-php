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
            new Picture([], new Image('/default/path'))
        );

        $this->assertSame($data, $heroBanner->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new HeroBanner(
                [new Link('subject', 'subject-url')],
                new Link('link', 'url'),
                Meta::withText('meta'),
                new Picture([], new Image('path/to/image')),
                'summary',
                'author line'
            )]
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/hero-banner.mustache';
    }
}

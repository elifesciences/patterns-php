<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ButtonCollection;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\ListHeading;
use eLife\Patterns\ViewModel\Paragraph;
use eLife\Patterns\ViewModel\PersonalisedCoverDownload;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\SiteHeaderTitle;
use InvalidArgumentException;

final class PersonalisedCoverDownloadTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'siteHeaderTitle' => [
                'homePagePath' => 'https://example.org',
                'isWrapped' => true,
                'borderVariant' => true,
                'disableMediaQuery' => false,
            ],
            'title' => 'title',
            'text' => [
                [
                    'text' => 'foo',
                ],
            ],
            'picture' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
            ],
            'a4ListHeading' => [
                'heading' => 'A4',
                'headingId' => 'buttons-a4',
            ],
            'a4ButtonCollection' => [
                'buttons' => [
                    [
                        'classes' => 'button--default',
                        'path' => 'path',
                        'text' => 'text',
                    ],
                ],
                'classes' => 'button-collection--a4',
            ],
            'letterListHeading' => [
                'heading' => 'US Letter',
                'headingId' => 'buttons-letter',
            ],
            'letterButtonCollection' => [
                'buttons' => [
                    [
                        'classes' => 'button--default',
                        'path' => 'path',
                        'text' => 'text',
                    ],
                ],
                'classes' => 'button-collection--letter',
            ],
        ];

        $download = new PersonalisedCoverDownload(
            new SiteHeaderTitle($data['siteHeaderTitle']['homePagePath'], $data['siteHeaderTitle']['isWrapped'], $data['siteHeaderTitle']['borderVariant'], $data['siteHeaderTitle']['disableMediaQuery']),
            $data['title'],
            array_map(function (array $paragraph) {
                return new Paragraph($paragraph['text']);
            }, $data['text']),
            new Picture([], new Image($data['picture']['fallback']['defaultPath'])),
            new ListHeading($data['a4ListHeading']['heading'], $data['a4ListHeading']['headingId']),
            new ButtonCollection([Button::link($data['a4ButtonCollection']['buttons'][0]['text'], $data['a4ButtonCollection']['buttons'][0]['path'])]),
            new ListHeading($data['letterListHeading']['heading'], $data['letterListHeading']['headingId']),
            new ButtonCollection([Button::link($data['letterButtonCollection']['buttons'][0]['text'], $data['letterButtonCollection']['buttons'][0]['path'])])
        );

        $this->assertSame($data['siteHeaderTitle'], $download['siteHeaderTitle']->toArray());
        $this->assertSame($data['title'], $download['title']);
        $this->assertSameWithoutOrder($data['text'], $download['text']);
        $this->assertSame($data['a4ListHeading'], $download['a4ListHeading']->toArray());
        $this->assertSame($data['a4ButtonCollection'], $download['a4ButtonCollection']->toArray());
        $this->assertSame($data['letterListHeading'], $download['letterListHeading']->toArray());
        $this->assertSame($data['letterButtonCollection'], $download['letterButtonCollection']->toArray());
        $this->assertSame($data, $download->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_empty_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new PersonalisedCoverDownload(new SiteHeaderTitle('/home/page/path', true, true), 'title', [], new Picture([], new Image('path')), new ListHeading('heading'), new ButtonCollection([Button::link('text', 'path')]), new ListHeading('heading'), new ButtonCollection([Button::link('text', 'path')]));
    }

    /**
     * @test
     */
    public function it_cannot_have_non_paragraph_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new PersonalisedCoverDownload(new SiteHeaderTitle('/home/page/path', true, true), 'title', ['foo'], new Picture([], new Image('path')), new ListHeading('heading'), new ButtonCollection([Button::link('text', 'path')]), new ListHeading('heading'), new ButtonCollection([Button::link('text', 'path')]));
    }

    public function viewModelProvider() : array
    {
        return [
            [new PersonalisedCoverDownload(new SiteHeaderTitle('/home/page/path', true, true), 'title', [new Paragraph('foo')], new Picture([], new Image('path')), new ListHeading('heading'), new ButtonCollection([Button::link('text', 'path')]), new ListHeading('heading'), new ButtonCollection([Button::link('text', 'path')]))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/personalised-cover-download.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArchiveNavLink;
use eLife\Patterns\ViewModel\BlockLink;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Picture;

final class ArchiveNavLinkTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'blockLink' => [
                'text' => 'text',
                'url' => 'url',
                'image' => [
                    'fallback' => [
                        'altText' => '',
                        'defaultPath' => '/default/path',
                    ],
                ],
            ],
        ];

        $archiveNavLink = ArchiveNavLink::basic(new BlockLink(new Link('text', 'url'), new Picture([], new Image('/default/path'))));

        $this->assertSame($data['blockLink'], $data['blockLink']);
        $this->assertSame($data, $archiveNavLink->toArray());

        $data = [
            'blockLink' => [
                'text' => 'text',
                'url' => 'url',
                'image' => [
                    'fallback' => [
                        'altText' => '',
                        'defaultPath' => '/default/path',
                    ],
                ],
            ],
            'label' => 'label',
            'links' => [
                [
                    'name' => 'name',
                    'url' => 'url',
                ],
            ],
        ];

        $archiveNavLink = ArchiveNavLink::withLinks(new BlockLink(new Link('text', 'url'),
            new Picture([], new Image('/default/path'))), 'label', [new Link('name', 'url')]);

        $this->assertSame($data['blockLink'], $data['blockLink']);
        $this->assertSame($data['label'], $data['label']);
        $this->assertSame($data['links'], $data['links']);
        $this->assertSame($data, $archiveNavLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'without links' => [
                ArchiveNavLink::basic(new BlockLink(new Link('text', 'url'))),
            ],
            'with links' => [
                ArchiveNavLink::withLinks(new BlockLink(new Link('text', 'url'),
                    new Picture([], new Image('/default/path'))), 'label', [new Link('name', 'url')]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/archive-nav-link.mustache';
    }
}

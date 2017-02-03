<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArchiveNavLink;
use eLife\Patterns\ViewModel\BackgroundImage;
use eLife\Patterns\ViewModel\BlockLink;
use eLife\Patterns\ViewModel\Link;

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
                'behaviour' => 'BackgroundImage',
                'backgroundImage' => [
                    'lowResImageSource' => 'lores.jpg',
                    'highResImageSource' => 'hires.jpg',
                    'thresholdWidth' => 100,
                ],
            ],
        ];

        $archiveNavLink = ArchiveNavLink::basic(new BlockLink(new Link('text', 'url'), new BackgroundImage('lores.jpg', 'hires.jpg', 100)));

        $this->assertSame($data['blockLink'], $data['blockLink']);
        $this->assertSame($data, $archiveNavLink->toArray());

        $data = [
            'blockLink' => [
                'text' => 'text',
                'url' => 'url',
                'behaviour' => 'BackgroundImage',
                'backgroundImage' => [
                    'lowResImageSource' => 'lores.jpg',
                    'highResImageSource' => 'hires.jpg',
                    'thresholdWidth' => 100,
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
            new BackgroundImage('lores.jpg', 'hires.jpg', 100)), 'label', [new Link('name', 'url')]);

        $this->assertSame($data['blockLink'], $data['blockLink']);
        $this->assertSame($data['label'], $data['label']);
        $this->assertSame($data['links'], $data['links']);
        $this->assertSame($data, $archiveNavLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'without links' => [
                ArchiveNavLink::basic(new BlockLink(new Link('text', 'url'), new BackgroundImage('lores.jpg', 'hires.jpg', 100))),
            ],
            'with links' => [
                ArchiveNavLink::withLinks(new BlockLink(new Link('text', 'url'),
                    new BackgroundImage('lores.jpg', 'hires.jpg', 100)), 'label', [new Link('name', 'url')]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/archive-nav-link.mustache';
    }
}

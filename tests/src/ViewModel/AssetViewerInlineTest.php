<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AdditionalAsset;
use eLife\Patterns\ViewModel\AdditionalAssets;
use eLife\Patterns\ViewModel\AssetViewerInline;
use eLife\Patterns\ViewModel\CaptionedAsset;
use eLife\Patterns\ViewModel\CaptionText;
use eLife\Patterns\ViewModel\DownloadLink;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MediaSource;
use eLife\Patterns\ViewModel\MediaType;
use eLife\Patterns\ViewModel\Table;
use eLife\Patterns\ViewModel\Video;

final class AssetViewerInlineTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'variant' => 'figure',
            'label' => 'label',
            'figuresPageFragLink' => '#id',
            'captionedAsset' => [
                'captionText' => [
                    'heading' => 'heading',
                ],
                'image' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                    'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                ],
            ],
            'additionalAssets' => [
                [
                    'assets' => [
                        [
                            'assetId' => 'id',
                            'captionText' => [
                                'heading' => 'Without doi',
                            ],
                            'nonDoiLink' => 'http://google.com/',
                            'downloadLink' => [
                                'name' => 'Download link',
                                'url' => 'http://google.com/download',
                                'fileName' => 'File name',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $viewer = AssetViewerInline::primary('id', 'label',
            new CaptionedAsset(new Image('/default/path',
                [500 => '/path/to/image/500/wide', 250 => '/default/path']), new CaptionText('heading')),
            [
                AdditionalAsset::withoutDoi('id', new CaptionText('Without doi'), DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'), 'File name'), 'http://google.com/'),
            ]);

        $this->assertSame($data['id'], $viewer['id']);
        $this->assertSame($data['variant'], $viewer['variant']);
        $this->assertSame($data['label'], $viewer['label']);
        $this->assertSame($data['figuresPageFragLink'], $viewer['figuresPageFragLink']);
        $this->assertSame($data['captionedAsset'], $viewer['captionedAsset']->toArray());
        $this->assertCount(1, $viewer['additionalAssets']);
        $this->assertSame($data['additionalAssets'][0], $viewer['additionalAssets'][0]->toArray());
        $this->assertSame($data, $viewer->toArray());

        $data = [
            'id' => 'id',
            'variant' => 'video',
            'label' => 'label',
            'figuresPageFragLink' => '#id',
            'captionedAsset' => [
                'captionText' => [
                    'heading' => 'heading',
                ],
                'video' => [
                    'sources' => [
                        [
                            'src' => '/file.mp4',
                            'mediaType' => [
                                'forMachine' => 'video/mp4',
                                'forHuman' => 'MPEG-4',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $viewer = AssetViewerInline::primary('id', 'label',
            new CaptionedAsset(new Video([new MediaSource('/file.mp4', new MediaType('video/mp4'))]), new CaptionText('heading')));

        $this->assertSame($data['id'], $viewer['id']);
        $this->assertSame($data['variant'], $viewer['variant']);
        $this->assertSame($data['label'], $viewer['label']);
        $this->assertSame($data['figuresPageFragLink'], $viewer['figuresPageFragLink']);
        $this->assertSame($data['captionedAsset'], $viewer['captionedAsset']->toArray());
        $this->assertSame($data, $viewer->toArray());

        $data = [
            'id' => 'id',
            'variant' => 'table',
            'label' => 'label',
            'figuresPageFragLink' => '#id',
            'captionedAsset' => [
                'captionText' => [
                    'heading' => 'heading',
                ],
                'table' => [
                    'tables' => [
                        '<table><tr><td>foo</td></tr></table>',
                    ],
                ],
            ],
        ];

        $viewer = AssetViewerInline::primary('id', 'label',
            new CaptionedAsset(new Table(['<table><tr><td>foo</td></tr></table>']), new CaptionText('heading')));

        $this->assertSame($data['id'], $viewer['id']);
        $this->assertSame($data['variant'], $viewer['variant']);
        $this->assertSame($data['label'], $viewer['label']);
        $this->assertSame($data['figuresPageFragLink'], $viewer['figuresPageFragLink']);
        $this->assertSame($data['captionedAsset'], $viewer['captionedAsset']->toArray());
        $this->assertSame($data, $viewer->toArray());

        $data = [
            'id' => 'id',
            'variant' => 'supplement',
            'isSupplement' => true,
            'supplementOrdinal' => 1,
            'parentId' => 'parentId',
            'label' => 'label',
            'figuresPageFragLink' => '#id',
            'captionedAsset' => [
                'captionText' => [
                    'heading' => 'heading',
                ],
                'image' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                    'srcset' => '/path/to/image/500/wide 500w, /default/path 250w',
                ],
            ],
        ];

        $viewer = AssetViewerInline::supplement('id', 1, 'parentId', 'label',
            new CaptionedAsset(new Image('/default/path',
                [500 => '/path/to/image/500/wide', 250 => '/default/path']), new CaptionText('heading')));

        $this->assertSame($data['id'], $viewer['id']);
        $this->assertSame($data['variant'], $viewer['variant']);
        $this->assertSame($data['isSupplement'], $viewer['isSupplement']);
        $this->assertSame($data['supplementOrdinal'], $viewer['supplementOrdinal']);
        $this->assertSame($data['parentId'], $viewer['parentId']);
        $this->assertSame($data['label'], $viewer['label']);
        $this->assertSame($data['figuresPageFragLink'], $viewer['figuresPageFragLink']);
        $this->assertSame($data['captionedAsset'], $viewer['captionedAsset']->toArray());
        $this->assertSame($data, $viewer->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'primary' => [
                AssetViewerInline::primary('id', 'label',
                    new CaptionedAsset(new Image('/default/path',
                        [500 => '/path/to/image/500/wide', 250 => '/default/path']), new CaptionText('heading'))),
            ],
            'supplement' => [
                AssetViewerInline::supplement('id', 1, 'parentId', 'label',
                    new CaptionedAsset(new Image('/default/path',
                        [500 => '/path/to/image/500/wide', 250 => '/default/path']), new CaptionText('heading')), [
                        AdditionalAsset::withoutDoi('id', new CaptionText('Without doi'), DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'),
                            'File name'), 'http://google.com/'),
                    ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/asset-viewer-inline.mustache';
    }
}

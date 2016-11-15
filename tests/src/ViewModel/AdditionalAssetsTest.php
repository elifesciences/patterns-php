<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AdditionalAsset;
use eLife\Patterns\ViewModel\AdditionalAssets;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\DownloadLink;
use eLife\Patterns\ViewModel\Link;

final class AdditionalAssetsTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'heading' => 'Some title',
            'assets' => [
                [
                    'assetId' => 'id',
                    'headingPart1' => 'without doi',
                    'headingPart2' => 'without doi 2',
                    'nonDoiLink' => 'http://google.com/',
                    'textPart' => 'text',
                    'downloadLink' => [
                        'name' => 'download link',
                        'url' => 'http://google.com/download',
                        'fileName' => 'file name',
                    ],
                ],
            ],
        ];
        $additionalAssets = new AdditionalAssets($data['heading'],
            [
                AdditionalAsset::withoutDoi(
                    $data['assets'][0]['assetId'],
                    $data['assets'][0]['headingPart1'],
                    DownloadLink::fromLink(
                        new Link($data['assets'][0]['downloadLink']['name'], $data['assets'][0]['downloadLink']['url']),
                        $data['assets'][0]['downloadLink']['fileName']
                    ),
                    $data['assets'][0]['headingPart2'],
                    $data['assets'][0]['nonDoiLink'],
                    'text'
                ),
            ]);

        $this->assertSame('Some title', $additionalAssets['heading']);
        $this->assertCount(1, $additionalAssets['assets']);
        $this->assertSame($data['assets'][0], $additionalAssets['assets'][0]->toArray());
        $this->assertSame($data, $additionalAssets->toArray());
    }

    public function viewModelProvider() : array
    {
        $downloadLink = DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'), 'File name');

        return [
            [
                new AdditionalAssets(null,
                    [AdditionalAsset::withDoi('id', 'With doi', $downloadLink, null, new Doi('10.7554/eLife.10181.001'))]),
            ],
            [
                new AdditionalAssets('Some title',
                    [AdditionalAsset::withoutDoi('id', 'Without doi', $downloadLink, null, 'http://google.com/')]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/additional-assets.mustache';
    }
}

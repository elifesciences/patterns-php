<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AdditionalAssetData;
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
            'data' => [
                [
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
        $sourceData = new AdditionalAssets($data['heading'],
            [
                AdditionalAssetData::withoutDoi(
                    $data['data'][0]['headingPart1'],
                    DownloadLink::fromLink(
                        new Link($data['data'][0]['downloadLink']['name'], $data['data'][0]['downloadLink']['url']),
                        $data['data'][0]['downloadLink']['fileName']
                    ),
                    $data['data'][0]['headingPart2'],
                    $data['data'][0]['nonDoiLink'],
                    'text'
                ),
            ]);
        $this->assertSameWithoutOrder($data, $sourceData);

        $dataDoi = [
            'heading' => 'Some title',
            'data' => [
                [
                    'headingPart1' => 'with doi',
                    'doi' => [
                        'doi' => '10.7554/eLife.10181.001',
                    ],
                ],
            ],
        ];
        $sourceDataDoi = new AdditionalAssets($data['heading'], [
            AdditionalAssetData::withDoi(
                $dataDoi['data'][0]['headingPart1'],
                DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'), 'File name'),
                null,
                new Doi($dataDoi['data'][0]['doi']['doi'])
            ),
        ]);
        $this->assertSameWithoutOrder($dataDoi, $sourceDataDoi);
    }

    public function viewModelProvider() : array
    {
        $downloadLink = DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'), 'File name');

        return [
            [
                new AdditionalAssets(null,
                    [AdditionalAssetData::withDoi('With doi', $downloadLink, null, new Doi('10.7554/eLife.10181.001'))]),
            ],
            [
                new AdditionalAssets('Some title',
                    [AdditionalAssetData::withDoi('With doi', $downloadLink, null, new Doi('10.7554/eLife.10181.001'))]),
            ],
            [
                new AdditionalAssets('Some title',
                    [AdditionalAssetData::withoutDoi('Without doi', $downloadLink, null, 'http://google.com/')]),
            ],
            [
                new AdditionalAssets('Some title',
                    [
                        AdditionalAssetData::withoutDoi('Without doi', $downloadLink, 'part 2', 'http://google.com/', 'text'),
                    ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/additional-assets.mustache';
    }
}

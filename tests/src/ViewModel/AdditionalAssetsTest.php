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
                    'headingPart' => 'without doi',
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
                AdditionalAssetData::withoutDoi(new Link($data['data'][0]['headingPart'],
                    $data['data'][0]['nonDoiLink']), 'text',
                    DownloadLink::fromLink(new Link($data['data'][0]['downloadLink']['name'],
                        $data['data'][0]['downloadLink']['url']), $data['data'][0]['downloadLink']['fileName'])),
            ]);
        $this->assertSameWithoutOrder($data, $sourceData);

        $dataDoi = [
            'heading' => 'Some title',
            'data' => [
                [
                    'headingPart' => 'with doi',
                    'doi' => [
                        'doi' => '10.7554/eLife.10181.001',
                    ],
                ],
            ],
        ];
        $sourceDataDoi = new AdditionalAssets($data['heading'], [
            AdditionalAssetData::withDoi($dataDoi['data'][0]['headingPart'],
                new Doi($dataDoi['data'][0]['doi']['doi'])),
        ]);
        $this->assertSameWithoutOrder($dataDoi, $sourceDataDoi);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new AdditionalAssets('Some title',
                    [AdditionalAssetData::withDoi('With doi', new Doi('10.7554/eLife.10181.001'))]),
            ],
            [
                new AdditionalAssets('Some title',
                    [AdditionalAssetData::withoutDoi(new Link('Without doi', 'http://google.com/'))]),
            ],
            [
                new AdditionalAssets('Some title',
                    [
                        AdditionalAssetData::withoutDoi(new Link('Without doi', 'http://google.com/'), 'text',
                            DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'),
                                'File name')),
                    ]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/additional-assets.mustache';
    }
}

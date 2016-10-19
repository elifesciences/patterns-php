<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AdditionalAssetData;
use eLife\Patterns\ViewModel\AdditionalAssets;
use eLife\Patterns\ViewModel\Doi;

class AdditionalAssetsTest extends ViewModelTest
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
                    'headingPart' => 'with doi',
                    'nonDoiLink' => 'http://google.com/',
                ],
            ],
        ];
        $sourceData = new AdditionalAssets($data['heading'], [AdditionalAssetData::withoutDoi($data['data'][0]['headingPart'], $data['data'][0]['nonDoiLink'])]);
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
        $sourceDataDoi = new AdditionalAssets($data['heading'], [AdditionalAssetData::withDoi($dataDoi['data'][0]['headingPart'], new Doi($dataDoi['data'][0]['doi']['doi']))]);
        $this->assertSameWithoutOrder($dataDoi, $sourceDataDoi);
    }

    public function viewModelProvider() : array
    {
        $m1 = new AdditionalAssets('Some title', [AdditionalAssetData::withoutDoi('Without doi', 'http://google.com/')]);
//        var_dump($m1->toArray());
//        exit;
        return [
            [
                new AdditionalAssets('Some title', [AdditionalAssetData::withDoi('With doi', new Doi('10.7554/eLife.10181.001'))]),
            ],
            [
                new AdditionalAssets('Some title', [AdditionalAssetData::withoutDoi('Without doi', 'http://google.com/')]),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/additional-assets.mustache';
    }
}

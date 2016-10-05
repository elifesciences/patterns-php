<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\SourceData;

class SourceDataTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'with doi',
            'nonDoiLink' => 'http://google.com/',
        ];
        $sourceData = SourceData::withoutDoi($data['text'], $data['nonDoiLink']);
        $this->assertSameWithoutOrder($data, $sourceData);

        $dataDoi = [
            'text' => 'with doi',
            'doi' => [
                    'doi' => '10.7554/eLife.10181.001',
                ],
        ];
        $sourceDataDoi = SourceData::withDoi($dataDoi['text'], new Doi($dataDoi['doi']['doi']));
        $this->assertSameWithoutOrder($dataDoi, $sourceDataDoi);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                SourceData::withDoi('With doi', new Doi('10.7554/eLife.10181.001')),
            ],
            [
                SourceData::withoutDoi('Without doi', 'http://google.com/'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/source-data.mustache';
    }
}

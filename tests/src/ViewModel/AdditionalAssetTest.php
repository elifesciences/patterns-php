<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AdditionalAsset;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\DownloadLink;
use eLife\Patterns\ViewModel\Link;

final class AdditionalAssetTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data =
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
            ];
        $additionalAsset = AdditionalAsset::withoutDoi(
            $data['assetId'],
            $data['headingPart1'],
            DownloadLink::fromLink(
                new Link($data['downloadLink']['name'], $data['downloadLink']['url']), $data['downloadLink']['fileName']
            ),
            $data['headingPart2'],
            $data['nonDoiLink'],
            'text');

        $this->assertSame($data['assetId'], $additionalAsset['assetId']);
        $this->assertSame($data['headingPart1'], $additionalAsset['headingPart1']);
        $this->assertSame($data['headingPart2'], $additionalAsset['headingPart2']);
        $this->assertSame($data['nonDoiLink'], $additionalAsset['nonDoiLink']);
        $this->assertSame($data['textPart'], $additionalAsset['textPart']);
        $this->assertSame($data['downloadLink'], $additionalAsset['downloadLink']->toArray());
        $this->assertSame($data, $additionalAsset->toArray());

        $data = [
            'assetId' => 'id',
            'headingPart1' => 'with doi',
            'doi' => [
                'doi' => '10.7554/eLife.10181.001',
                'variant' => 'asset',
            ],
            'downloadLink' => [
                'name' => 'download link',
                'url' => 'http://google.com/download',
                'fileName' => 'file name',
            ],
        ];
        $additionalAsset = AdditionalAsset::withDoi(
            $data['assetId'],
            $data['headingPart1'],
            DownloadLink::fromLink(
                new Link($data['downloadLink']['name'], $data['downloadLink']['url']), $data['downloadLink']['fileName']
            ),
            null,
            new Doi($data['doi']['doi'])
        );

        $this->assertSame($data['assetId'], $additionalAsset['assetId']);
        $this->assertSame($data['headingPart1'], $additionalAsset['headingPart1']);
        $this->assertSame($data['doi'], $additionalAsset['doi']->toArray());
        $this->assertSame($data['downloadLink'], $additionalAsset['downloadLink']->toArray());
        $this->assertSame($data, $additionalAsset->toArray());
    }

    public function viewModelProvider() : array
    {
        $downloadLink = DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'), 'File name');

        return [
            'minimum DOI' => [AdditionalAsset::withDoi('id', 'With doi', $downloadLink, null, new Doi('10.7554/eLife.10181.001'))],
            'complete DOI' => [AdditionalAsset::withDoi('id', 'With doi', $downloadLink, 'part 2', new Doi('10.7554/eLife.10181.001'))],
            'minimum without DOI' => [AdditionalAsset::withoutDoi('id', 'Without doi', $downloadLink, null, 'http://google.com/')],
            'complete without DOI' => [AdditionalAsset::withoutDoi('id', 'Without doi', $downloadLink, 'part 2', 'http://google.com/', 'text')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/additional-asset.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\AdditionalAsset;
use eLife\Patterns\ViewModel\CaptionText;
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
                'captionText' => [
                    'heading' => 'heading',
                    'standfirst' => 'standfirst',
                    'text' => 'text',
                ],
                'nonDoiLink' => 'http://google.com/',
                'downloadLink' => [
                    'link' => [
                        'name' => 'download link',
                        'url' => 'http://google.com/download'
                    ],
                    'fileName' => 'file name',
                ],
            ];
        $additionalAsset = AdditionalAsset::withoutDoi(
            $data['assetId'],
            CaptionText::withHeading($data['captionText']['heading'], $data['captionText']['standfirst'], $data['captionText']['text']),
            DownloadLink::fromLink(
                new Link($data['downloadLink']['link']['name'], $data['downloadLink']['link']['url']), $data['downloadLink']['fileName']
            ),
            $data['nonDoiLink']
        );

        $this->assertSame($data['assetId'], $additionalAsset['assetId']);
        $this->assertSame($data['captionText'], $additionalAsset['captionText']->toArray());
        $this->assertSame($data['nonDoiLink'], $additionalAsset['nonDoiLink']);
        $this->assertSame($data['downloadLink'], $additionalAsset['downloadLink']->toArray());
        $this->assertSame($data, $additionalAsset->toArray());

        $data = [
            'assetId' => 'id',
            'captionText' => [
                'heading' => 'heading',
            ],
            'doi' => [
                'doi' => '10.7554/eLife.10181.001',
                'variant' => 'asset',
            ],
        ];
        $additionalAsset = AdditionalAsset::withDoi(
            $data['assetId'],
            CaptionText::withHeading($data['captionText']['heading']),
            null,
            new Doi($data['doi']['doi'])
        );

        $this->assertSame($data['assetId'], $additionalAsset['assetId']);
        $this->assertSame($data['captionText'], $additionalAsset['captionText']->toArray());
        $this->assertSame($data['doi'], $additionalAsset['doi']->toArray());
        $this->assertSame($data, $additionalAsset->toArray());
    }

    public function viewModelProvider() : array
    {
        $downloadLink = DownloadLink::fromLink(new Link('Download link', 'http://google.com/download'), 'File name');

        return [
            'minimum DOI' => [AdditionalAsset::withDoi('id', CaptionText::withHeading('heading'), null, new Doi('10.7554/eLife.10181.001'))],
            'complete DOI' => [AdditionalAsset::withDoi('id', CaptionText::withHeading('heading', 'stand first', 'text'), $downloadLink, new Doi('10.7554/eLife.10181.001'))],
            'minimum without DOI' => [AdditionalAsset::withoutDoi('id', CaptionText::withHeading('heading'), null, 'http://google.com/')],
            'complete without DOI' => [AdditionalAsset::withoutDoi('id', CaptionText::withHeading('heading', 'stand first', 'text'), $downloadLink, 'http://google.com/')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/additional-asset.mustache';
    }
}

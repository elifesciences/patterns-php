<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\ArticleDownloadLink;
use eLife\Patterns\ViewModel\Link;
use PHPUnit_Framework_TestCase;

final class ArticleDownloadLinkTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $articleDownloadLink = new ArticleDownloadLink(new Link('name', 'url'));

        $this->assertInstanceOf(CastsToArray::class, $articleDownloadLink);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'primary' => [
                'link' => [
                    'name' => 'primary name',
                    'url' => 'primary url'
                ],
                'checkPMC' => 'https://checkpmc.example',
            ],
            'secondary' => [
                'name' => 'secondary name', 'url' => 'secondary url',
            ]
        ];

        $articleDownloadLink = new ArticleDownloadLink(
            new Link('primary name', 'primary url'),
            new Link('secondary name', 'secondary url'),
            'https://checkpmc.example'
        );

        $this->assertSame($data['primary']['link'], $articleDownloadLink['primary']['link']->toArray());
        $this->assertSame($data['secondary'], $articleDownloadLink['secondary']->toArray());
        $this->assertSame($data['primary']['checkPMC'], $articleDownloadLink['primary']['checkPMC']);
        $this->assertSame($data, $articleDownloadLink->toArray());
    }

    /**
     * @test
     */
    public function it_may_have_a_check_pmc_url()
    {
        $with = new ArticleDownloadLink(
            new Link('primary name', 'primary url'),
            null,
            'https://checkpmc.example'
        );
        $without = new ArticleDownloadLink(
            new Link('primary name', 'primary url')
        );

        $this->assertArrayHasKey('checkPMC', $with->toArray()['primary']);

        $this->assertArrayNotHasKey('checkPMC', $without->toArray()['primary']);
    }
}

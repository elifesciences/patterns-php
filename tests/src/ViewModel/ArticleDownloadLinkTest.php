<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\ArticleDownloadLink;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\PrimaryLink;
use PHPUnit_Framework_TestCase;

final class ArticleDownloadLinkTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $articleDownloadLink = new ArticleDownloadLink(new PrimaryLink(new Link('name', 'url')));

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
                'checkPMC' => 'https://checkpmc.example'
            ],
            'secondary' => [
                'name' => 'secondary name', 'url' => 'secondary url',
            ],
        ];

        $articleDownloadLink = new ArticleDownloadLink(new PrimaryLink(
                new Link('primary name', 'primary url'),
                'https://checkpmc.example'
            ),
            new Link('secondary name', 'secondary url'),
            
        );

        $this->assertSame($data['primary'], $articleDownloadLink['primary']->toArray());
        $this->assertSame($data['secondary'], $articleDownloadLink['secondary']->toArray());
        $this->assertSame($data, $articleDownloadLink->toArray());
    }
}

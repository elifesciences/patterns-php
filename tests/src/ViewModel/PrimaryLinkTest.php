<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\ArticleDownloadLink;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\PrimaryLink;
use PHPUnit_Framework_TestCase;

final class PrimaryLinkTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'link' => [
                'name' => 'primary name',
                'url' => 'primary url'
            ],
            'checkPMC' => 'https://checkpmc.example'
        ];

        $primaryLink = new PrimaryLink(
            new Link('primary name', 'primary url'),
            'https://checkpmc.example'
        );

        $this->assertSame($data['link'], $primaryLink['link']->toArray());
        $this->assertSame($data['checkPMC'], $primaryLink['checkPMC']);
        $this->assertSame($data, $primaryLink->toArray());
    }

    /**
     * @test
     */
    public function it_may_have_a_check_pmc_url()
    {
        $with = new PrimaryLink(new Link('primary name', 'primary url'), 'https://checkpmc.example');
        $without = new PrimaryLink(new Link('primary name', 'primary url'));

        $this->assertArrayHasKey('checkPMC', $with->toArray());

        $this->assertArrayNotHasKey('checkPMC', $without->toArray());
    }
}

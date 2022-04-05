<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\ArticleDownloadLink;
use eLife\Patterns\ViewModel\ArticleDownloadLinksGroup;
use eLife\Patterns\ViewModel\Link;
use PHPUnit_Framework_TestCase;

final class ArticleDownloadLinksGroupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $articleDownloadLinksGroup = new ArticleDownloadLinksGroup(
            'group title',
            [
                new ArticleDownloadLink(
                    new Link('name', 'url')
                ),
            ],
            'intro text'
        );

        $this->assertInstanceOf(CastsToArray::class, $articleDownloadLinksGroup);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'jsHideGroup' => true,
            'id' => 'id',
            'title' => 'group title',
            'items' => [
                [
                    'primary' => [
                        'name' => 'primary name',
                        'url' => 'primary url',
                        'attributes' => [
                            [
                                'key' => 'key',
                                'value' => 'value',
                            ],
                        ],
                    ],
                    'secondary' => [
                        'name' => 'secondary name',
                        'url' => 'secondary url',
                    ],
                ],
            ],
            'intro' => 'intro text',
        ];

        $articleDownloadLinksGroup = new ArticleDownloadLinksGroup(
            'group title',
            [
                new ArticleDownloadLink(
                    new Link('primary name', 'primary url', false, ['key' => 'value']),
                    new Link('secondary name', 'secondary url')
                ),
            ],
            'intro text',
            'id',
            true
        );

        $this->assertSame($data, $articleDownloadLinksGroup->toArray());
    }
}

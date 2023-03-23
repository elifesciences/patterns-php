<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleDownloadLink;
use eLife\Patterns\ViewModel\ArticleDownloadLinksGroup;
use eLife\Patterns\ViewModel\ArticleDownloadLinksList;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class ArticleDownloadLinksListTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'description' => 'description',
            'groups' => [
                [
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
                            'checkPMC' => 'https://checkpmc.example',
                        ],
                    ],
                    'intro' => 'intro text',
                ],
            ],
        ];

        $downloadList = new ArticleDownloadLinksList(
            'id',
            'description',
            [
                new ArticleDownloadLinksGroup(
                    'group title',
                    [
                        new ArticleDownloadLink(
                            new Link('primary name', 'primary url', null, false, ['key' => 'value']),
                            new Link('secondary name', 'secondary url'),
                            'https://checkpmc.example'
                        ),
                    ],
                    'intro text',
                    'id',
                    true
                ),
            ]
        );

        $this->assertSame($data, $downloadList->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList(
            '',
            'description',
            [
                new ArticleDownloadLinksGroup(
                    'group title',
                    [
                        new ArticleDownloadLink(new Link('name', 'url')),
                    ]
                ),
            ]
        );
    }

    /**
     * @test
     */
    public function it_must_have_a_description()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList(
            'id',
            '',
            [
                new ArticleDownloadLinksGroup(
                    'group title',
                    [
                        new ArticleDownloadLink(new Link('name', 'url')),
                    ]
                ),
            ]
        );
    }

    /**
     * @test
     */
    public function it_must_have_a_group()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList('id', 'description', []);
    }

    /**
     * @test
     */
    public function groups_must_have_at_least_1_item()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList('id', 'description', [
            new ArticleDownloadLinksGroup(
                'group title',
                []
            ),
        ]);
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new ArticleDownloadLinksList(
                    'id',
                    'description',
                    [
                        new ArticleDownloadLinksGroup(
                            'group title',
                            [
                                new ArticleDownloadLink(
                                    new Link('name', 'url', null, false, ['key' => 'value'])
                                ),
                            ]
                        ),
                    ]
                ),
            ],
            [
                new ArticleDownloadLinksList(
                    'id',
                    'description',
                    [
                        new ArticleDownloadLinksGroup(
                            'group title',
                            [
                                new ArticleDownloadLink(
                                    new Link('name', 'url', null, false, ['key' => 'value']),
                                    new Link('name', 'url', null, false, ['key' => 'value'])
                                ),
                            ]
                        ),
                    ]
                ),
            ],
            [
                new ArticleDownloadLinksList(
                    'id',
                    'description',
                    [
                        new ArticleDownloadLinksGroup(
                            'group title',
                            [
                                new ArticleDownloadLink(
                                    new Link('name', 'url', null, false, ['key' => 'value']),
                                    new Link('name', 'url', null, false, ['key' => 'value'])
                                ),
                            ],
                            'intro text'
                        ),
                    ]
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/article-download-links-list.mustache';
    }
}

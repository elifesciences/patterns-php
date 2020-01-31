<?php

namespace tests\eLife\Patterns\ViewModel;

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
                ],
            ],
        ];

        $downloadList = new ArticleDownloadLinksList(
            'id',
            'description',
            [
                'group title' => [
                    'primary' => new Link('primary name', 'primary url', false, ['key' => 'value']),
                    'secondary' => new Link('secondary name', 'secondary url'),
                ]
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
                'group title' => [
                    'primary' => new Link('name', 'url')
                ]
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
                'group title' => [
                    'primary'=> new Link('name', 'url')
                ]
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

        new ArticleDownloadLinksList('id', 'description', ['group title' => []]);
    }

    /**
     * @test
     */
    public function items_must_contain_the_key_primary()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList('id', 'description', ['group title' => ['foo']]);
    }

    /**
     * @test
     */
    public function items_may_only_contain_the_keys_primary_and_secondary()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList('id', 'description',
            [
                'group title' => ['primary', 'secondary', 'foo']
            ]
        );
    }

    /**
     * @test
     */
    public function items_may_contain_the_keys_primary_and_secondary()
    {

        new ArticleDownloadLinksList('id', 'description',
            [
                'group title' => ['primary', 'secondary']
            ]
        );
    }


    public function viewModelProvider() : array
    {
        return [
            [
                new ArticleDownloadLinksList(
                    'id',
                    'description',
                    [
                        'group title' => [
                            'primary' => new Link('name', 'url', false, ['key' => 'value']),
                        ],
                    ]
                )
            ],
            [
                new ArticleDownloadLinksList(
                    'id',
                    'description',
                    [
                        'group title' => [
                            'primary' => new Link('name', 'url', false, ['key' => 'value']),
                            'secondary' => new Link('name', 'url', false, ['key' => 'value'])
                        ],
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

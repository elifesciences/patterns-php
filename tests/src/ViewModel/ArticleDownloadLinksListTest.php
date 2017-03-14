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
                    'title' => 'group',
                    'items' => [
                        [
                            'name' => 'name',
                            'url' => 'url',
                        ],
                    ],
                ],
            ],
        ];

        $downloadList = new ArticleDownloadLinksList('id', 'description', ['group' => [new Link('name', 'url')]]);

        $this->assertSame($data, $downloadList->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_an_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList('', 'description', ['group' => [new Link('name', 'url')]]);
    }

    /**
     * @test
     */
    public function it_must_have_a_description()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList('id', '', ['group' => [new Link('name', 'url')]]);
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
    public function groups_must_have_at_least_1_link()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList('id', 'description', ['group' => []]);
    }

    /**
     * @test
     */
    public function groups_must_have_a_link()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleDownloadLinksList('id', 'description', ['group' => ['foo']]);
    }

    public function viewModelProvider() : array
    {
        return [
            [new ArticleDownloadLinksList('id', 'description', ['group' => [new Link('name', 'url')]])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/article-download-links-list.mustache';
    }
}

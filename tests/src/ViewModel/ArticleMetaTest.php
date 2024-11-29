<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleMeta;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class ArticleMetaTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'groups' => [
                [
                    'title' => 'group',
                    'items' => [
                        ['name' => 'link', 'url' => 'url'],
                        ['name' => 'non-link', 'url' => false],
                    ],
                ],
            ],
        ];

        $articleMeta = new ArticleMeta(['group' => [new Link('link', 'url'), new Link('non-link')]]);

        $this->assertSame($data['groups'][0]['title'], $articleMeta['groups'][0]['title']);
        $this->assertSame($data['groups'][0]['items'][0], $articleMeta['groups'][0]['items'][0]->toArray());
        $this->assertSame($data['groups'][0]['items'][1], $articleMeta['groups'][0]['items'][1]->toArray());
        $this->assertSame($data, $articleMeta->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_group()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleMeta([]);
    }

    /**
     * @test
     */
    public function it_must_have_an_array_of_items()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleMeta(['group' => 'foo']);
    }

    /**
     * @test
     */
    public function it_must_have_items()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleMeta(['group' => []]);
    }

    /**
     * @test
     */
    public function it_must_have_link_items()
    {
        $this->expectException(InvalidArgumentException::class);

        new ArticleMeta(['group' => ['foo']]);
    }

    public function viewModelProvider(): array
    {
        return [
            [new ArticleMeta(['group' => [new Link('link', 'url'), new Link('non-link')]])],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/article-meta.mustache';
    }
}

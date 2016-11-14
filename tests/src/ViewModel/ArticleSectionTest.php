<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleSection;
use eLife\Patterns\ViewModel\Doi;
use InvalidArgumentException;

final class ArticleSectionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $basicData = [
            'id' => 'id',
            'doi' => [
                'doi' => '10.7554/eLife.10181.001',
                'variant' => 'article-section',
            ],
            'title' => 'some title',
            'headingLevel' => 2,
            'hasBehaviour' => false,
            'isInitiallyClosed' => false,
            'body' => '<p>body</p>',
            'isFirst' => true,
        ];

        $basicArticleSection = ArticleSection::basic('some title', 2, '<p>body</p>', 'id',
            new Doi('10.7554/eLife.10181.001'), true);

        $this->assertSame($basicData['id'], $basicArticleSection['id']);
        $this->assertSameWithoutOrder($basicData['doi'], $basicArticleSection['doi']);
        $this->assertSame($basicData['title'], $basicArticleSection['title']);
        $this->assertSame($basicData['headingLevel'], $basicArticleSection['headingLevel']);
        $this->assertSame($basicData['hasBehaviour'], $basicArticleSection['hasBehaviour']);
        $this->assertSame($basicData['isInitiallyClosed'], $basicArticleSection['isInitiallyClosed']);
        $this->assertSame($basicData['body'], $basicArticleSection['body']);
        $this->assertSame($basicData['isFirst'], $basicArticleSection['isFirst']);
        $this->assertSameWithoutOrder($basicData, $basicArticleSection);

        $collapsibleData = [
            'id' => 'id',
            'doi' => [
                'doi' => '10.7554/eLife.10181.001',
                'variant' => 'article-section',
            ],
            'title' => 'some title',
            'headingLevel' => 2,
            'hasBehaviour' => true,
            'isInitiallyClosed' => true,
            'body' => '<p>body</p>',
            'isFirst' => true,
        ];

        $collapsibleArticleSection = ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>', true, true,
            new Doi('10.7554/eLife.10181.001'));

        $this->assertSame($collapsibleData['id'], $collapsibleArticleSection['id']);
        $this->assertSameWithoutOrder($collapsibleData['doi'], $collapsibleArticleSection['doi']);
        $this->assertSame($collapsibleData['title'], $collapsibleArticleSection['title']);
        $this->assertSame($collapsibleData['headingLevel'], $collapsibleArticleSection['headingLevel']);
        $this->assertSame($collapsibleData['hasBehaviour'], $collapsibleArticleSection['hasBehaviour']);
        $this->assertSame($collapsibleData['isInitiallyClosed'], $collapsibleArticleSection['isInitiallyClosed']);
        $this->assertSame($collapsibleData['body'], $collapsibleArticleSection['body']);
        $this->assertSame($collapsibleData['isFirst'], $collapsibleArticleSection['isFirst']);
        $this->assertSameWithoutOrder($collapsibleData, $collapsibleArticleSection);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_doi_without_an_id()
    {
        $this->expectException(InvalidArgumentException::class);

        ArticleSection::basic('some title', 2, '<p>body</p>', null, new Doi('10.7554/eLife.10181.001'));
    }

    public function viewModelProvider() : array
    {
        return [
            'basic minimum' => [ArticleSection::basic('some title', 2, '<p>body</p>')],
            'basic complete' => [
                ArticleSection::basic('some title', 2, '<p>body</p>', 'id', new Doi('10.7554/eLife.10181.001'), true),
            ],
            'collapsible minimum' => [ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>')],
            'collapsible complete' => [
                ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>', true, true,
                    new Doi('10.7554/eLife.10181.001')),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/article-section.mustache';
    }
}

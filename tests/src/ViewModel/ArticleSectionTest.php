<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleSection;

final class ArticleSectionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $basicData = [
            'id' => 'id',
            'title' => 'some title',
            'headingLevel' => 2,
            'hasBehaviour' => false,
            'isInitiallyClosed' => false,
            'body' => '<p>body</p>',
            'isFirst' => true,
        ];

        $basicArticleSection = ArticleSection::basic('some title', 2, '<p>body</p>', 'id', true);

        $this->assertSame($basicData['id'], $basicArticleSection['id']);
        $this->assertSame($basicData['title'], $basicArticleSection['title']);
        $this->assertSame($basicData['headingLevel'], $basicArticleSection['headingLevel']);
        $this->assertSame($basicData['hasBehaviour'], $basicArticleSection['hasBehaviour']);
        $this->assertSame($basicData['isInitiallyClosed'], $basicArticleSection['isInitiallyClosed']);
        $this->assertSame($basicData['body'], $basicArticleSection['body']);
        $this->assertSame($basicData['isFirst'], $basicArticleSection['isFirst']);
        $this->assertSame($basicData, $basicArticleSection->toArray());

        $collapsibleData = [
            'id' => 'id',
            'title' => 'some title',
            'headingLevel' => 2,
            'hasBehaviour' => true,
            'isInitiallyClosed' => true,
            'body' => '<p>body</p>',
            'isFirst' => true,
        ];

        $collapsibleArticleSection = ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>', true, true);

        $this->assertSame($collapsibleData['id'], $collapsibleArticleSection['id']);
        $this->assertSame($collapsibleData['title'], $collapsibleArticleSection['title']);
        $this->assertSame($collapsibleData['headingLevel'], $collapsibleArticleSection['headingLevel']);
        $this->assertSame($collapsibleData['hasBehaviour'], $collapsibleArticleSection['hasBehaviour']);
        $this->assertSame($collapsibleData['isInitiallyClosed'], $collapsibleArticleSection['isInitiallyClosed']);
        $this->assertSame($collapsibleData['body'], $collapsibleArticleSection['body']);
        $this->assertSame($collapsibleData['isFirst'], $collapsibleArticleSection['isFirst']);
        $this->assertSame($collapsibleData, $collapsibleArticleSection->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'basic minimum' => [ArticleSection::basic('some title', 2, '<p>body</p>')],
            'basic complete' => [ArticleSection::basic('some title', 2, '<p>body</p>', 'id', true)],
            'collapsible minimum' => [ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>')],
            'collapsible complete' => [ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>', true, true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/article-section.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleSection;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class ArticleSectionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $basicData = [
            'classes' => 'article-section--default',
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
            'headerLink' => new Link('Request a detailed protocol', '#'),
            'relatedLinks' => [
                new Link('Related link 1', '#'),
                new Link('Related link 2', '#'),
            ],
        ];

        $basicArticleSection = ArticleSection::basic('<p>body</p>', 'some title', 2, 'id',
            new Doi('10.7554/eLife.10181.001'), $basicData['relatedLinks'], ArticleSection::STYLE_DEFAULT,
            true, $basicData['headerLink']);

        $this->assertSame($basicData['classes'], $basicArticleSection['classes']);
        $this->assertSame($basicData['id'], $basicArticleSection['id']);
        $this->assertSameWithoutOrder($basicData['doi'], $basicArticleSection['doi']);
        $this->assertSame($basicData['title'], $basicArticleSection['title']);
        $this->assertSame($basicData['headingLevel'], $basicArticleSection['headingLevel']);
        $this->assertSame($basicData['hasBehaviour'], $basicArticleSection['hasBehaviour']);
        $this->assertSame($basicData['isInitiallyClosed'], $basicArticleSection['isInitiallyClosed']);
        $this->assertSame($basicData['body'], $basicArticleSection['body']);
        $this->assertSame($basicData['isFirst'], $basicArticleSection['isFirst']);
        $this->assertSame($basicData['headerLink'], $basicArticleSection['headerLink']);
        $this->assertSame($basicData['relatedLinks'], $basicArticleSection['relatedLinks']);
        $this->assertSameWithoutOrder($basicData, $basicArticleSection);

        $collapsibleData = [
            'classes' => 'article-section--highlighted',
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
            'relatedLinks' => [
                new Link('Related link 1', '#'),
                new Link('Related link 2', '#'),
            ],
        ];

        $collapsibleArticleSection = ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>',
            $collapsibleData['relatedLinks'], ArticleSection::STYLE_HIGHLIGHTED, true, true,
            new Doi('10.7554/eLife.10181.001'));

        $this->assertSame($collapsibleData['classes'], $collapsibleArticleSection['classes']);
        $this->assertSame($collapsibleData['id'], $collapsibleArticleSection['id']);
        $this->assertSameWithoutOrder($collapsibleData['doi'], $collapsibleArticleSection['doi']);
        $this->assertSame($collapsibleData['title'], $collapsibleArticleSection['title']);
        $this->assertSame($collapsibleData['headingLevel'], $collapsibleArticleSection['headingLevel']);
        $this->assertSame($collapsibleData['hasBehaviour'], $collapsibleArticleSection['hasBehaviour']);
        $this->assertSame($collapsibleData['isInitiallyClosed'], $collapsibleArticleSection['isInitiallyClosed']);
        $this->assertSame($collapsibleData['body'], $collapsibleArticleSection['body']);
        $this->assertSame($collapsibleData['isFirst'], $collapsibleArticleSection['isFirst']);
        $this->assertSame($collapsibleData['relatedLinks'], $collapsibleArticleSection['relatedLinks']);
        $this->assertSameWithoutOrder($collapsibleData, $collapsibleArticleSection);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_title_without_a_heading_level()
    {
        $this->expectException(InvalidArgumentException::class);

        ArticleSection::basic('<p>body</p>', 'some title', null);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_header_link_without_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        ArticleSection::basic('<p>body</p>', null, null, null, null, null,
            null, false, new Link('Request a detailed protocol', '#'));
    }

    /**
     * @test
     */
    public function it_cannot_have_a_heading_level_without_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        ArticleSection::basic('<p>body</p>', null, 2);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_doi_without_an_id()
    {
        $this->expectException(InvalidArgumentException::class);

        ArticleSection::basic('<p>body</p>', null, null, null, new Doi('10.7554/eLife.10181.001'));
    }

    public function viewModelProvider() : array
    {
        return [
            'basic minimum' => [ArticleSection::basic('<p>body</p>')],
            'basic complete' => [
                ArticleSection::basic('<p>body</p>', 'some title', 2, 'id',
                    new Doi('10.7554/eLife.10181.001'), [new Link('Related link', '#')],
                    ArticleSection::STYLE_DEFAULT, false, new Link('Request a detailed protocol', '#')),
            ],
            'collapsible minimum' => [ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>')],
            'collapsible complete' => [
                ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>',
                    [new Link('Related link', '#')], ArticleSection::STYLE_DEFAULT, true, true,
                    new Doi('10.7554/eLife.10181.001'))
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/article-section.mustache';
    }
}

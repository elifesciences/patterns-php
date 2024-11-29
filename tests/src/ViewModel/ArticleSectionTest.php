<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleAssessmentTerms;
use eLife\Patterns\ViewModel\Assessment;
use eLife\Patterns\ViewModel\ArticleSection;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Term;
use InvalidArgumentException;

final class ArticleSectionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $basicData = [
            'classes' => 'article-section--default test-class',
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
            'relatedLinksSeparator' => 'circle',
            'assessment' => new Assessment(
                new ArticleAssessmentTerms(
                    'significance',
                    'description',
                    [
                        new Term('Landmark'),
                        new Term('Valuable', true),
                    ]
                ),
                new ArticleAssessmentTerms(
                    'strength',
                    'description',
                    [
                        new Term('Exceptional'),
                        new Term('Solid', true),
                    ]
                ),
                'summary'
            )
        ];

        $basicArticleSection = ArticleSection::basic(
            '<p>body</p>',
            'some title',
            2,
            'id',
            new Doi('10.7554/eLife.10181.001'),
            $basicData['relatedLinks'],
            ArticleSection::STYLE_DEFAULT,
            true,
            $basicData['headerLink'],
            $basicData['relatedLinksSeparator'],
            'test-class',
            null,
            new Assessment(
                new ArticleAssessmentTerms('significance', 'description', [new Term('Landmark'), new Term('Valuable', true)]),
                new ArticleAssessmentTerms('strength', 'description', [new Term('Exceptional'), new Term('Solid', true)]),
                'summary'
            )
        );

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
        $this->assertSame($basicData['relatedLinksSeparator'], $basicArticleSection['relatedLinksSeparator']);
        $this->assertEquals($basicData['assessment'], $basicArticleSection['assessment']);
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
            'relatedLinksSeparator' => 'circle',
            'assessment' => new Assessment(
                new ArticleAssessmentTerms(
                    'significance',
                    'description',
                    [
                        new Term('Landmark'),
                        new Term('Valuable', true),
                    ]
                ),
                new ArticleAssessmentTerms(
                    'strength',
                    'description',
                    [
                        new Term('Exceptional'),
                        new Term('Solid', true),
                    ]
                ),
                'summary'
            )
        ];

        $collapsibleArticleSection = ArticleSection::collapsible(
            'id',
            'some title',
            2,
            '<p>body</p>',
            $collapsibleData['relatedLinks'],
            ArticleSection::STYLE_HIGHLIGHTED,
            true,
            true,
            new Doi('10.7554/eLife.10181.001'),
            ArticleSection::RELATED_LINKS_SEPARATOR_CIRCLE,
            new Assessment(
                new ArticleAssessmentTerms('significance', 'description', [new Term('Landmark'), new Term('Valuable', true)]),
                new ArticleAssessmentTerms('strength', 'description', [new Term('Exceptional'), new Term('Solid', true)]),
                'summary'
            )
        );

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
        $this->assertSame($collapsibleData['relatedLinksSeparator'], $collapsibleArticleSection['relatedLinksSeparator']);
        $this->assertEquals($collapsibleData['assessment'], $collapsibleArticleSection['assessment']);
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

        ArticleSection::basic(
            '<p>body</p>',
            null,
            null,
            null,
            null,
            null,
            null,
            false,
            new Link('Request a detailed protocol', '#')
        );
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

    /**
     * @test
     */
    public function it_cannot_have_a_related_links_separator_without_related_Links()
    {
        $this->expectException(InvalidArgumentException::class);

        ArticleSection::basic(
            '<p>body</p>',
            null,
            null,
            null,
            null,
            null,
            null,
            false,
            null,
            ArticleSection::RELATED_LINKS_SEPARATOR_CIRCLE
        );
    }

    /**
     * @test
     */
    public function it_cannot_have_heading_level_and_has_editor_title()
    {
        $this->expectException(InvalidArgumentException::class);

        ArticleSection::basic(
            '<p>body</p>',
            'title',
            3,
            null,
            null,
            null,
            null,
            false,
            null,
            ArticleSection::RELATED_LINKS_SEPARATOR_CIRCLE,
            null,
            true
        );
    }

    /**
     * @test
     */
    public function it_must_have_a_valid_related_links_separator()
    {
        $this->expectException(InvalidArgumentException::class);

        ArticleSection::basic(
            '<p>body</p>',
            null,
            null,
            null,
            null,
            [new Link('Related link 1', '#'), new Link('Related link 2', '#')],
            null,
            false,
            null,
            'not valid'
        );
    }

    public function viewModelProvider(): array
    {
        return [
            'basic minimum' => [ArticleSection::basic('<p>body</p>')],
            'basic complete' => [
                ArticleSection::basic(
                    '<p>body</p>',
                    'some title',
                    2,
                    'id',
                    new Doi('10.7554/eLife.10181.001'),
                    [new Link('Related link', '#')],
                    ArticleSection::STYLE_DEFAULT,
                    false,
                    new Link('Request a detailed protocol', '#'),
                    ArticleSection::RELATED_LINKS_SEPARATOR_CIRCLE,
                    null,
                    null,
                    new Assessment(
                        new ArticleAssessmentTerms('significance', 'description', [new Term('Landmark'), new Term('Valuable', true)]),
                        new ArticleAssessmentTerms('strength', 'description', [new Term('Exceptional'), new Term('Solid', true)]),
                        'summary'
                    )
                )
            ],
            'collapsible minimum' => [ArticleSection::collapsible('id', 'some title', 2, '<p>body</p>')],
            'collapsible complete' => [
                ArticleSection::collapsible(
                    'id',
                    'some title',
                    2,
                    '<p>body</p>',
                    [new Link('Related link', '#')],
                    ArticleSection::STYLE_DEFAULT,
                    true,
                    true,
                    new Doi('10.7554/eLife.10181.001'),
                    ArticleSection::RELATED_LINKS_SEPARATOR_CIRCLE,
                    new Assessment(
                        new ArticleAssessmentTerms('significance', 'description', [new Term('Landmark'), new Term('Valuable', true)]),
                        new ArticleAssessmentTerms('strength', 'description', [new Term('Exceptional'), new Term('Solid', true)]),
                        'summary'
                    )
                )
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/article-section.mustache';
    }
}

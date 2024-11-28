<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleAssessmentTerms;
use eLife\Patterns\ViewModel\Term;

final class ArticleAssesmentTermsTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'some title',
            'termDescription' => 'description',
            'terms' => [
                [
                    'term' => 'Landmark',
                    'isHighlighted' => false,
                ],
                [
                    'term' => 'Fundamental',
                    'isHighlighted' => false,
                ],
                [
                    'term' => 'Important',
                    'isHighlighted' => false,
                ],
                [
                    'term' => 'Valuable',
                    'isHighlighted' => true,
                ],
                [
                    'term' => 'Useful',
                    'isHighlighted' => false,
                ]
            ],
            'termDescriptionAriaLabel' => 'aria'
        ];

        $articleAssessmentTerms = new ArticleAssessmentTerms(
            $data['title'],
            $data['termDescription'],
            [
                new Term('Landmark'),
                new Term('Fundamental'),
                new Term('Important'),
                new Term('Valuable', true),
                new Term('Useful'),
            ],
            $data['termDescriptionAriaLabel']
        );

        $this->assertSame($data, $articleAssessmentTerms->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new ArticleAssessmentTerms(
                    'title',
                    'description',
                    [new Term('Exceptional'), new Term('Solid', true)],
                    'aria'
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/article-assessment-terms.mustache';
    }
}

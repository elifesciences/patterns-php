<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleAssessmentTerms;

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
                    'term' => 'Landmark'
                ],
                [
                    'term' => 'Fundamental'
                ],
                [
                    'term' => 'Important'
                ],
                [
                    'term' => 'Valuable',
                    'isHighlighted' => true,
                ],
                [
                    'term' => 'Useful'
                ]
            ],
            'termDescriptionAriaLabel' => 'aria'
        ];

        $articleAssessmentTerms = new ArticleAssessmentTerms(
            $data['title'],
            $data['termDescription'],
            $data['terms'],
            $data['termDescriptionAriaLabel']
        );

        $this->assertSame($data, $articleAssessmentTerms->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new ArticleAssessmentTerms('title', 'description', [['term' => 'Exceptional'], ['term' => 'Solid', 'isHighlighted' => true]]), 'aria'],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/article-assessment-terms.mustache';
    }
}

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

        $articleAssesmentTerms = new ArticleAssessmentTerms(
            $data['title'],
            $data['termDescription'],
            array_reduce($data['terms'], function (array $carry, array $item) {
                $termData = ['term' => $item['term']];

                if (isset($item['isHighlighted']) && $item['isHighlighted']) {
                    $termData['isHighlighted'] = true;
                }

                $carry[] = $termData;
                return $carry;
            }, []),
            $data['termDescriptionAriaLabel']
        );

        $this->assertSame($data, $articleAssesmentTerms->toArray());
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

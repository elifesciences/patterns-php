<?php

namespace src\ViewModel;

use eLife\Patterns\ViewModel\AssessmentTermsArticle;
use tests\eLife\Patterns\ViewModel\ViewModelTest;

final class AssessmentTermsArticleTest extends ViewModelTest
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

        $assessmentTerm = new AssessmentTermsArticle(
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

        $this->assertSame($data, $assessmentTerm->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new AssessmentTermsArticle('title', 'description', [['term' => 'Exceptional'], ['term' => 'Solid', 'isHighlighted' => true]]), 'aria'],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/assessment-terms-article.mustache';
    }
}

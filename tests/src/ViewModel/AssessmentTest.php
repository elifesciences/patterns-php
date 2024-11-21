<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleAssessmentTerms;
use eLife\Patterns\ViewModel\Assessment;
use PHPUnit_Framework_TestCase;

final class AssessmentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'significance' => [
                'title' => 'significance',
                'termDescription' => 'description',
                'terms' => [
                    [
                        'term' => 'Landmark'
                    ],
                    [
                        'term' => 'Valuable',
                        'isHighlighted' => true,
                    ]
                ]
            ],
            'strength' => [
                'title' => 'strength',
                'termDescription' => 'description',
                'terms' => [
                    [
                        'term' => 'Exceptional'
                    ],
                    [
                        'term' => 'Solid',
                        'isHighlighted' => true,
                    ]
                ]
            ],
            'summary' => 'summary'
        ];

        $assessment = new Assessment(
            new ArticleAssessmentTerms('significance', 'description', [['term' => 'Landmark'], ['term' => 'Valuable', 'isHighlighted' => true]]),
            new ArticleAssessmentTerms('strength', 'description', [['term' => 'Exceptional'], ['term' => 'Solid', 'isHighlighted' => true]]),
            'summary'
        );

        $this->assertSame($data, $assessment->toArray());
    }
}

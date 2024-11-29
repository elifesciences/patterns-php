<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ArticleAssessmentTerms;
use eLife\Patterns\ViewModel\Assessment;
use eLife\Patterns\ViewModel\Term;
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
                        'term' => 'Landmark',
                        'value' => 'Landmark',
                        'isHighlighted' => false,
                    ],
                    [
                        'term' => 'Valuable',
                        'value' => 'Valuable',
                        'isHighlighted' => true,
                    ]
                ]
            ],
            'strength' => [
                'title' => 'strength',
                'termDescription' => 'description',
                'terms' => [
                    [
                        'term' => 'Exceptional',
                        'value' => 'Exceptional',
                        'isHighlighted' => false,
                    ],
                    [
                        'term' => 'Solid',
                        'value' => 'Solid',
                        'isHighlighted' => true,
                    ]
                ]
            ],
            'summary' => 'summary'
        ];

        $assessment = new Assessment(
            new ArticleAssessmentTerms('significance', 'description', [new Term('Landmark'), new Term('Valuable', true)]),
            new ArticleAssessmentTerms('strength', 'description', [new Term('Exceptional'), new Term('Solid', true)]),
            'summary'
        );

        $this->assertSame($data, $assessment->toArray());
    }
}

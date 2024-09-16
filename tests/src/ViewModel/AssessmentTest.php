<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Assessment;
use eLife\Patterns\ViewModel\Link;
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
            'summary'
        ];

        $assessment = new Assessment(
            new Term('significance', 'description', [['term' => 'Landmark'], ['term' => 'Valuable', 'isHighlighted' => true]]),
            new Term('strength', 'description', [['term' => 'Exceptional'], ['term' => 'Solid', 'isHighlighted' => true]]),
            'summary'
        );

        $this->assertSame($data, $assessment->toArray());
    }
}

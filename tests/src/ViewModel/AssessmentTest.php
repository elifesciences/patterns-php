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
                'description' => 'description',
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
                'description' => 'description',
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

        $this->assertSame($data['significance']['title'], $assessment['significance']['title']->toArray());
        $this->assertSame($data['significance']['description'], $assessment['significance']['description']->toArray());
        $this->assertSame($data['strength']['title'], $assessment['strength']['title']->toArray());
        $this->assertSame($data['strength']['description'], $assessment['strength']['description']->toArray());
        $this->assertSame($data['summary'], $assessment['summary']);
        $this->assertSame($data, $assessment->toArray());
    }
}

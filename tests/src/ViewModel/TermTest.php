<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Term;
use InvalidArgumentException;

final class TermTest extends ViewModelTest
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
        ];

        $term = new Term(
            $data['title'],
            $data['description'],
            array_reduce($data['terms'], function (array $carry, array $item) {
                $carry[] = [
                    'term' => $item['term'],
                    'isHighlighted' => $item['isHighlighted'] ?? false
                ];
                return $carry;
            }, [])
        );

        $this->assertSame($data, $term->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new Term('title', 'description', [['term' => 'Exceptional'], ['term' => 'Solid', 'isHighlighted' => true]])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/term.mustache';
    }
}

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
            'description' => 'description',
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

        $term = new Term(array_reduce($data['terms'], function (array $carry, array $item) {
            $carry[$item['term']] = $item['isHighlighted'];

            return $carry;
        }, []));

        $this->assertSame($data['title'], $term['title']);
        $this->assertSame($data['description'], $term['description']);
        $this->assertSame($data['items'], $term['items']);
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

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Term;

final class TermTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'value' => 'Valuable',
            'isHighlighted' => true,
        ];

        $term = new Term('Valuable', true);

        $this->assertSame($data, $term->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new Term('Important')],
            [new Term('Valuable', true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/term.mustache';
    }
}

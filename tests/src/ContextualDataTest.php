<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContextualData;
use eLife\Patterns\ViewModel\Doi;

final class ContextualDataTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'views' => 303,
            'comments' => 202,
            'cited' => 101,
            'doi' => [
                    'uri' => '#',
                    'classNames' => 'contextual-data__doi',
                ],
            'cite_as' => 'cited as',
        ];

        $contextualData = new ContextualData($data['cite_as'], $data['views'], $data['comments'], $data['cited'], new Doi($data['doi']['uri']));
        $this->assertEquals($data['doi']['classNames'], 'contextual-data__doi');
        $this->assertSameWithoutOrder($data, $contextualData);
    }

    public function viewModelProvider() : array
    {
        return [
            [new ContextualData('cited as', 303, 202, 101, new Doi('#'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/contextual-data.mustache';
    }
}

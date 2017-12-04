<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\HypothesisOpener;

final class HypothesisOpenerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'annotationCount' => 3,
            'button' => [
                'text' => "<span aria-hidden=\"true\">3 </span><span class=\"visuallyhidden\">Open annotations (there are currently 3 annotations on this page). </span>",
                'type' => 'button'
            ],
        ];

        $hypothesisAffordance = new HypothesisOpener($data['annotationCount']);

        unset($data['annotationCount']);
        $this->assertSameWithoutOrder($data, $hypothesisAffordance->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new HypothesisOpener(3)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/hypothesis-opener.mustache';
    }
}

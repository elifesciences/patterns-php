<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\HypothesisOpener;

final class HypothesisOpenerTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'button' => [
                'text' => '<span aria-hidden="true"><span data-visible-annotation-count>&#8220;</span></span><span class="visuallyhidden"> Open annotations (there are currently <span data-hypothesis-annotation-count>0</span> annotations on this page).</span>',
                'type' => 'button',
            ],
        ];

        $hypothesisAffordance = new HypothesisOpener();
        $this->assertSameWithoutOrder($data, $hypothesisAffordance->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [new HypothesisOpener()],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/hypothesis-opener.mustache';
    }
}

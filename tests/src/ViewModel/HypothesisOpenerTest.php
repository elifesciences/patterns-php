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
            'button' => [
                'text' => '<span aria-hidden="true">3</span><span class="visuallyhidden">Open annotations (there are currently 3 annotations on this page).</span>',
                'type' => 'button',
                'name' => 'theName',
                'id' => 'theId',
                'isPopulated' => true,
                'isActive' => true,
            ],
        ];

        $hypothesisAffordance = new HypothesisOpener(Button::speechBubble($data['button']['text'], $data['button']['isActive'], $data['button']['name'], $data['button']['id'], $data['button']['isPopulated']));
        unset($data['button']['isActive'], $data['button']['isPopulated']);
        $this->assertSameWithoutOrder($data, $hypothesisAffordance->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [new HypothesisOpener(Button::speechBubble('<span aria-hidden="true">&#8220;</span><span class="visuallyhidden">Open annotations (there are currently no annotations on this page).</span>\''))],
            'full' => [new HypothesisOpener(Button::speechBubble('<span aria-hidden="true">3</span><span class="visuallyhidden">Open annotations (there are currently 3 annotations on this page).</span>', true, 'name', 'theId', true))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/hypothesis-opener.mustache';
    }
}

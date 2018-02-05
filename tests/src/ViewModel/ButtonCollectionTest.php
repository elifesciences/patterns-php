<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ButtonCollection;

final class ButtonCollectionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'buttons' => [
                [
                    'classes' => 'button--default',
                    'path' => 'path',
                    'text' => 'text',
                ],
            ],
            'centered' => true,
            'compact' => true,
        ];

        $blockLink = new ButtonCollection([Button::link($data['buttons'][0]['text'], $data['buttons'][0]['path'])], $data['centered'], $data['compact']);

        $this->assertSameWithoutOrder($data['buttons'], $blockLink['buttons']);
        $this->assertSame($data['centered'], $blockLink['centered']);
        $this->assertSame($data['compact'], $blockLink['compact']);
        $this->assertSame($data, $blockLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ButtonCollection([Button::link('text', 'path')])],
            'complete' => [new ButtonCollection([Button::link('text', 'path')], true, true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button-collection.mustache';
    }
}

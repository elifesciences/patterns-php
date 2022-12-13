<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;

final class ButtonActionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'Button action (citation)',
            'path' => '#citation',
            'classes' => 'button--default button--action icon icon-citation',
            'id' => 'button-action-citation'
        ];

        $buttonAction = Button::action($data['text'], true, 'citation');
        $this->assertSame($data, $buttonAction->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [Button::action('Button action')],
            'full' => [Button::action('Button action (citation)', true, 'citation')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use InvalidArgumentException;

final class ButtonActionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'Button action (citation)',
            'classes' => 'button--default button--action icon icon-citation',
            'id' => 'button-action-citation',
            'path' => '#citation'
        ];
        $buttonAction = Button::action($data['text'], true, 'citation');
        $this->assertSameWithoutOrder($data, $buttonAction->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_variant()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::action('text', true, 'foo');
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [Button::action('Button action')],
            'citation' => [Button::action('Button action (citation)', true, 'citation')],
            'comment' => [Button::action('Button action (comment)', true, 'comment')],
            'download' => [Button::action('Button action (download)', true, 'download')],
            'share' => [Button::action('Button action (share)', true, 'share')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button.mustache';
    }
}

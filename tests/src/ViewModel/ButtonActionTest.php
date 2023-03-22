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
            'path' => '#citation',
            'id' => 'button-action-citation',
            'classes' => 'button--default button--action icon icon-citation',
            'ariaLabel' => 'Button action'
        ];
        $buttonAction = Button::action($data['text'], $data['path'], 1, $data['id'], 'citation', $data['ariaLabel']);
        $this->assertSameWithoutOrder($data, $buttonAction->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_variant()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::action('text', "#", 1, null, 'foo');
    }

    /**
     * @test
     */
    public function it_may_have_hypothesis_trigger()
    {
        $with = Button::action('Button action (comment)', "#", 1, null, Button::ACTION_VARIANT_COMMENT);
        $without = Button::action('Button action', '#');

        $this->assertArrayHasKey('isHypothesisTrigger', $with->toArray());

        $this->assertArrayNotHasKey('isHypothesisTrigger', $without->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [Button::action('Button action', '#')],
            'citation' => [Button::action('Button action (citation)', "#", 1, null, Button::ACTION_VARIANT_CITATION)],
            'comment' => [Button::action('Button action (comment)', "#", 1, null, Button::ACTION_VARIANT_COMMENT)],
            'download' => [Button::action('Button action (download)', "#", 1, null, Button::ACTION_VARIANT_DOWNLOAD)],
            'share' => [Button::action('Button action (share)', "#", 1, null, Button::ACTION_VARIANT_SHARE)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button.mustache';
    }
}

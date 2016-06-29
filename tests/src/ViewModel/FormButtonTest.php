<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use InvalidArgumentException;

final class FormButtonTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'classes' => 'button--small button--outline button--full',
            'text' => 'text',
            'type' => Button::TYPE_BUTTON,
        ];

        $button = Button::form('text', Button::TYPE_BUTTON, Button::SIZE_SMALL, Button::STYLE_OUTLINE, true, true);

        $this->assertSame($data['text'], $button['text']);
        $this->assertSame($data['type'], $button['type']);
        $this->assertSame($data['classes'], $button['classes']);
        $this->assertSame($data, $button->toArray());
    }

    /**
     * @test
     */
    public function it_merges_outline_and_inactive_states()
    {
        $button = Button::form('text', Button::TYPE_BUTTON, Button::SIZE_MEDIUM, Button::STYLE_OUTLINE, false);

        $this->assertSame('button--outline-inactive', $button['classes']);
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::form('', Button::TYPE_BUTTON);
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::form('text', 'foo');
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_size()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::form('text', Button::TYPE_BUTTON, 'foo');
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_style()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::form('text', Button::TYPE_BUTTON, Button::SIZE_MEDIUM, 'foo');
    }

    public function viewModelProvider() : array
    {
        return [
            'button' => [Button::form('text', Button::TYPE_BUTTON)],
            'reset' => [Button::form('text', Button::TYPE_RESET)],
            'submit' => [Button::form('text', Button::TYPE_SUBMIT)],
            'small' => [Button::form('text', Button::TYPE_BUTTON, Button::SIZE_SMALL)],
            'extra small' => [Button::form('text', Button::TYPE_BUTTON, Button::SIZE_SMALL)],
            'outline' => [Button::form('text', Button::TYPE_BUTTON, Button::SIZE_MEDIUM, Button::STYLE_OUTLINE)],
            'inactive' => [
                Button::form('text', Button::TYPE_BUTTON, Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, false),
            ],
            'full width' => [
                Button::form('text', Button::TYPE_BUTTON, Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, true, true),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/button.mustache';
    }
}

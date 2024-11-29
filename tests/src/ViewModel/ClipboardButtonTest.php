<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use InvalidArgumentException;

final class ClipboardButtonTest extends ViewModelTest
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
            'name' => 'some name',
            'id' => 'someId',
            'clipboardText' => 'someClipboardText',
        ];

        $button = Button::clipboard('text', 'someClipboardText', $data['name'], Button::SIZE_SMALL, Button::STYLE_OUTLINE, 'someId', true, true);

        $this->assertSame($data['text'], $button['text']);
        $this->assertSame($data['clipboardText'], $button['clipboardText']);
        $this->assertSame($data['type'], $button['type']);
        $this->assertSame($data['classes'], $button['classes']);
        $this->assertSameWithoutOrder($data, $button);
    }

    /**
     * @test
     */
    public function it_merges_outline_and_inactive_states()
    {
        $button = Button::clipboard('text', 'someClipboardText', 'some name', Button::SIZE_MEDIUM, Button::STYLE_OUTLINE, 'someId', false);

        $this->assertSame('button--outline-inactive', $button['classes']);
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::clipboard('', 'someClipboardText', 'some name');
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_clipboard()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::clipboard('text', '', 'some name');
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_size()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::clipboard('text', 'someClipboardText', 'some name', 'foo');
    }

    /**
     * @test
     */
    public function it_cannot_have_an_invalid_style()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::clipboard('text', 'someClipboardText', 'some name', Button::SIZE_MEDIUM, 'foo');
    }

    public function viewModelProvider(): array
    {
        return [
            'small' => [Button::clipboard('text', 'someClipboardText', 'some name', Button::SIZE_SMALL)],
            'extra small' => [Button::clipboard('text', 'someClipboardText', 'some name', Button::SIZE_SMALL)],
            'outline' => [Button::clipboard('text', 'someClipboardText', 'some name', Button::SIZE_MEDIUM, Button::STYLE_OUTLINE)],
            'inactive' => [
                Button::clipboard('text', 'someClipboardText', 'some name', Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, 'id', false),
            ],
            'full width' => [
                Button::clipboard('text', 'someClipboardText', 'some name', Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, 'id', true, true),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/button.mustache';
    }
}

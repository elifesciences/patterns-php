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
            'classes' => 'class1 class2',
            'text' => 'text',
            'type' => Button::TYPE_BUTTON,
        ];

        $button = Button::form('text', Button::TYPE_BUTTON, ['class1', 'class2']);

        $this->assertSame($data['text'], $button['text']);
        $this->assertSame($data['type'], $button['type']);
        $this->assertSame($data['classes'], $button['classes']);
        $this->assertSame($data, $button->toArray());
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

    public function viewModelProvider() : array
    {
        return [
            'without class' => [Button::form('text', Button::TYPE_BUTTON)],
            'with class' => [Button::form('text', Button::TYPE_BUTTON, ['class'])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/button.mustache';
    }
}

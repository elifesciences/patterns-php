<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use InvalidArgumentException;

final class LinkButtonTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'classes' => 'class1 class2',
            'path' => 'path',
            'text' => 'text',
        ];

        $button = Button::link('text', 'path', ['class1', 'class2']);

        $this->assertSame($data['text'], $button['text']);
        $this->assertSame($data['path'], $button['path']);
        $this->assertSame($data['classes'], $button['classes']);
        $this->assertSame($data, $button->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::link('', 'path');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_path()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::link('text', '');
    }

    public function viewModelProvider() : array
    {
        return [
            'without class' => [Button::link('text', 'path')],
            'with class' => [Button::link('text', 'path', ['class'])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/button.mustache';
    }
}

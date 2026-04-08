<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class LinkButtonTest extends ViewModelTest
{
    #[Test]
    public function it_has_data()
    {
        $data = [
            'classes' => 'button--small button--outline button--full',
            'path' => 'path',
            'text' => 'text',
            'id' => 'someId',
            'ariaLabel' => 'Link buttton'
        ];

        $button = Button::link('text', 'path', Button::SIZE_SMALL, Button::STYLE_OUTLINE, true, true, 'someId', 'Link buttton');

        $this->assertSame($data['text'], $button['text']);
        $this->assertSame($data['path'], $button['path']);
        $this->assertSame($data['id'], $button['id']);
        $this->assertSame($data['classes'], $button['classes']);
        $this->assertSame($data['ariaLabel'], $button['ariaLabel']);
        $this->assertSame($data, $button->toArray());
    }

    #[Test]
    public function it_merges_outline_and_inactive_states()
    {
        $button = Button::link('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_OUTLINE, false);

        $this->assertSame('button--outline-inactive', $button['classes']);
    }

    #[Test]
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::link('', 'path');
    }

    #[Test]
    public function it_cannot_have_a_blank_path()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::link('text', '');
    }

    #[Test]
    public function it_cannot_have_an_invalid_size()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::link('text', 'path', Button::TYPE_BUTTON, 'foo');
    }

    #[Test]
    public function it_cannot_have_an_invalid_style()
    {
        $this->expectException(InvalidArgumentException::class);

        Button::link('text', 'path', Button::TYPE_BUTTON, Button::SIZE_MEDIUM, 'foo');
    }

    public static function viewModelProvider() : array
    {
        return [
            'button' => [Button::link('text', 'path')],
            'small' => [Button::link('text', 'path', Button::SIZE_SMALL)],
            'extra small' => [Button::link('text', 'path', Button::SIZE_SMALL)],
            'outline' => [Button::link('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_OUTLINE)],
            'inactive' => [Button::link('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, false)],
            'full width' => [Button::link('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, true, true)],
            'aria label' => [Button::link('text', 'path', Button::SIZE_MEDIUM, Button::STYLE_DEFAULT, true, true, 'Link button')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/button.mustache';
    }
}

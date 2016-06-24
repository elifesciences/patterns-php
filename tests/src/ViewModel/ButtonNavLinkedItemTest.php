<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\NavLinkedItem;
use TypeError;

final class ButtonNavLinkedItemTest extends ViewModelTest
{
    private $button;

    public function setUp()
    {
        parent::setUp();
        $this->button = Button::link('the button text', '/the/button/path', ['button-class-1', 'button-class-2']);
    }

    /**
     * @test
     */
    public function as_button_it_must_be_supplied_a_button()
    {
        $this->expectException(TypeError::class);
        NavLinkedItem::asButton(null);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
          'classes' => 'class-1 class-2',
          'button' => $this->button,
        ];

        $buttonNavLinkedItem = NavLinkedItem::asButton($this->button, ['class-1', 'class-2']);

        $this->assertSame($data['classes'], $buttonNavLinkedItem['classes']);
        $this->assertSame($data['button'], $buttonNavLinkedItem['button']);
    }

    public function viewModelProvider() : array
    {
        $button = Button::link('the button text', '/the/button/path', ['button-class-1', 'button-class-2']);

        return [
          'basic' => [NavLinkedItem::asButton($button)],
          'with classes' => [NavLinkedItem::asButton($button, ['class-1', 'class-2'])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/nav-linked-item.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\NavLinkedItem;
use TypeError;
use PHPUnit\Framework\Attributes\Test;

final class ButtonNavLinkedItemTest extends ViewModelTest
{
    private $button;

    public function setUp(): void
    {
        parent::setUp();
        $this->button = Button::link('the button text', '/the/button/path');
    }

    #[Test]
    public function as_button_it_must_be_supplied_a_button()
    {
        $this->expectException(TypeError::class);
        NavLinkedItem::asButton(null);
    }

    #[Test]
    public function it_has_data()
    {
        $data = [
            'button' => $this->button->toArray(),
        ];

        $buttonNavLinkedItem = NavLinkedItem::asButton($button = $this->button);

        $this->assertEquals($button, $buttonNavLinkedItem['button']);
        $this->assertSame($data, $buttonNavLinkedItem->toArray());
    }

    public static function viewModelProvider() : array
    {
        $button = Button::link('the button text', '/the/button/path');

        return [
            'basic' => [NavLinkedItem::asButton($button)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/nav-linked-item.mustache';
    }
}

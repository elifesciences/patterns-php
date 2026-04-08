<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\JumpMenu;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;

final class JumpMenuTest extends ViewModelTest
{
    #[Test]
    public function it_has_data()
    {
        $data = [
            'items' => [
                ['name' => 'name1', 'url' => 'url1'],
                ['name' => 'name2', 'url' => 'url2']
            ],
        ];

        $jumpMenu = new JumpMenu($items = [
            new Link($data['items'][0]['name'], $data['items'][0]['url']),
            new Link($data['items'][1]['name'], $data['items'][1]['url']),
        ]);

        $this->assertEquals($items, $jumpMenu['items']);
        $this->assertSame($data, $jumpMenu->toArray());
    }

    #[Test]
    public function items_must_be_links()
    {
        $this->expectException(InvalidArgumentException::class);

        new JumpMenu(['name']);
    }

    public static function viewModelProvider() : array
    {
        return [
            [new JumpMenu([new Link('link1', 'url1'), new Link('link2', 'url2')])],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/jump-menu.mustache';
    }
}

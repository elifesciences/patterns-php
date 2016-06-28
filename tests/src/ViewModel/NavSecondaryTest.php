<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\NavSecondary;
use eLife\Patterns\ViewModel\PictureSvgWithFallback;

final class NavSecondaryTest extends ViewModelTest
{

    /**
     * @test
     */
    public function it_has_data()
    {
        $img = new PictureSvgWithFallback(
          [
            ['svg' => '/path/to/svg']
          ],
          new Image('/path/to/fallback/', [500 => '/path/in/srcset'], 'alt text', [])
        );

        $linkItem1 = NavLinkedItem::asLink('item 1', '/item-1/', ['class-1'], ['text-class-1'], false, $img);
        $linkItem2 = NavLinkedItem::asLink('item 2', '/item-2/', ['class-2'], ['text-class-2'], false);

        $linkItems = [$linkItem1, $linkItem2];

        $navSecondary = new NavSecondary($linkItems);
        $navSecondaryItems = $navSecondary['navSecondaryLinks'];

        $this->assertSame($linkItem1['text'], $navSecondaryItems[0]['text']);
        $this->assertSame($linkItem1['path'], $navSecondaryItems[0]['path']);
        $this->assertSame($linkItem1['classes'], $navSecondaryItems[0]['classes']);
        $this->assertSame($linkItem1['rel'], $navSecondaryItems[0]['rel']);
        $this->assertSame($linkItem1['img'], $navSecondaryItems[0]['img']);

        $this->assertSame($linkItem2['text'], $navSecondaryItems[1]['text']);
        $this->assertSame($linkItem2['path'], $navSecondaryItems[1]['path']);
        $this->assertSame($linkItem2['classes'], $navSecondaryItems[1]['classes']);
        $this->assertSame($linkItem2['rel'], $navSecondaryItems[1]['rel']);
        $this->assertSame($linkItem2['img'], $navSecondaryItems[1]['img']);

    }

    public function viewModelProvider() : array
    {
        $img = new PictureSvgWithFallback(
            [
                ['svg' => '/path/to/svg']
            ],
            new Image('/path/to/fallback/', [500 => '/path/in/srcset'], 'alt text', [])
        );

        $navLinkItems = [
          NavLinkedItem::asLink('item 1', '/item-1/', ['class-1'], ['text-class-1'], false, $img),
          NavLinkedItem::asLink('item 2', '/item-2/', ['class-2'], ['text-class-2'], false),
        ];

        return [
            [new NavSecondary($navLinkItems)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/nav-secondary.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\NavPrimary;
use eLife\Patterns\ViewModel\PictureSvgWithFallback;

final class NavPrimaryTest extends ViewModelTest
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

        $navPrimary = new NavPrimary($linkItems);
        $navPrimaryItems = $navPrimary['navPrimaryLinks'];

        $this->assertSame($linkItem1['text'], $navPrimaryItems[0]['text']);
        $this->assertSame($linkItem1['path'], $navPrimaryItems[0]['path']);
        $this->assertSame($linkItem1['classes'], $navPrimaryItems[0]['classes']);
        $this->assertSame($linkItem1['rel'], $navPrimaryItems[0]['rel']);
        $this->assertSame($linkItem1['img'], $navPrimaryItems[0]['img']);

        $this->assertSame($linkItem2['text'], $navPrimaryItems[1]['text']);
        $this->assertSame($linkItem2['path'], $navPrimaryItems[1]['path']);
        $this->assertSame($linkItem2['classes'], $navPrimaryItems[1]['classes']);
        $this->assertSame($linkItem2['rel'], $navPrimaryItems[1]['rel']);
        $this->assertSame($linkItem2['img'], $navPrimaryItems[1]['img']);

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
            [new NavPrimary($navLinkItems)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/nav-primary.mustache';
    }
}

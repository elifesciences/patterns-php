<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\PictureSvgWithFallback;
use eLife\Patterns\ViewModel\SiteHeaderNavBar;

final class PrimarySiteHeaderNavBarTest extends ViewModelTest
{
    private $img;
    private $linkItem1;
    private $linkItem2;
    private $linkItem3;
    private $linkItems;
    private $siteHeaderNavBar;

    public function setUp()
    {
        parent::setUp();
        $this->img = new PictureSvgWithFallback(
          [
            ['svg' => '/path/to/svg'],
          ],
          new Image('/path/to/fallback/', [500 => '/path/in/srcset'], 'alt text', [])
        );
        $this->linkItem1 = NavLinkedItem::asLink('item 1', '/item-1/', ['class-1'], ['text-class-1'], false, $this->img);
        $this->linkItem2 = NavLinkedItem::asLink('item 2', '/item-2/', ['class-2'], ['text-class-2'], true);
        $this->linkItem3 = NavLinkedItem::asLink('item 2', '/item-2/', ['class-2'], ['text-class-2'], false);
        $this->linkItems = [$this->linkItem1, $this->linkItem2, $this->linkItem3];
        $this->siteHeaderNavBar = SiteHeaderNavBar::primary($this->linkItems);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $siteHeaderNavItems = $this->siteHeaderNavBar['linkedItems'];

        $this->assertSame($this->linkItem1['text'], $siteHeaderNavItems[0]['text']);
        $this->assertSame($this->linkItem1['path'], $siteHeaderNavItems[0]['path']);
        $this->assertSame($this->linkItem1['classes'], $siteHeaderNavItems[0]['classes']);
        $this->assertSame($this->linkItem1['rel'], $siteHeaderNavItems[0]['rel']);
        $this->assertSame($this->linkItem1['img'], $siteHeaderNavItems[0]['img']);

        $this->assertSame($this->linkItem2['text'], $siteHeaderNavItems[1]['text']);
        $this->assertSame($this->linkItem2['path'], $siteHeaderNavItems[1]['path']);
        $this->assertSame($this->linkItem2['classes'], $siteHeaderNavItems[1]['classes']);
        $this->assertSame($this->linkItem2['rel'], $siteHeaderNavItems[1]['rel']);
        $this->assertSame($this->linkItem2['img'], $siteHeaderNavItems[1]['img']);

        $this->assertSame($this->linkItem3['text'], $siteHeaderNavItems[2]['text']);
        $this->assertSame($this->linkItem3['path'], $siteHeaderNavItems[2]['path']);
        $this->assertSame($this->linkItem3['classes'], $siteHeaderNavItems[2]['classes']);
        $this->assertSame($this->linkItem3['rel'], $siteHeaderNavItems[2]['rel']);
        $this->assertSame($this->linkItem3['img'], $siteHeaderNavItems[2]['img']);
    }

    /**
     * @test
     */
    public function it_has_correct_outer_classes()
    {
        $this->assertSame($this->siteHeaderNavBar['classesOuter'], 'nav-primary');
    }

    /**
     * @test
     */
    public function it_has_correct_inner_classes()
    {
        $this->assertSame($this->siteHeaderNavBar['classesInner'], 'nav-primary__list clearfix');
    }

    public function viewModelProvider() : array
    {
        $img = new PictureSvgWithFallback(
            [
                ['svg' => '/path/to/svg'],
            ],
            new Image('/path/to/fallback/', [500 => '/path/in/srcset'], 'alt text', [])
        );

        $navLinkItems = [
          NavLinkedItem::asLink('item 1', '/item-1/', ['class-1'], ['text-class-1'], false, $img),
          NavLinkedItem::asLink('item 2', '/item-2/', ['class-2'], ['text-class-2'], false),
        ];

        return [
            [SiteHeaderNavBar::primary($navLinkItems)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/site-header-nav-bar.mustache';
    }
}

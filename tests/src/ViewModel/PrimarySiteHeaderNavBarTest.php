<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\SiteHeaderNavBar;

final class PrimarySiteHeaderNavBarTest extends ViewModelTest
{
    private $linkItem1;
    private $linkItem2;
    private $linkItem3;
    private $linkItems;
    private $siteHeaderNavBar;

    public function setUp()
    {
        parent::setUp();
        $this->linkItem1 = NavLinkedItem::asLink(new Link('item 1', '/item-1/'), false);
        $this->linkItem2 = NavLinkedItem::asLink(new Link('item 2', '/item-2/'), true);
        $this->linkItem3 = NavLinkedItem::asLink(new Link('item 2', '/item-2/'), false);
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
        $this->assertSame('nav-primary__item nav-primary__item--first', $siteHeaderNavItems[0]['classes']);
        $this->assertSame($this->linkItem1['rel'], $siteHeaderNavItems[0]['rel']);

        $this->assertSame($this->linkItem2['text'], $siteHeaderNavItems[1]['text']);
        $this->assertSame($this->linkItem2['path'], $siteHeaderNavItems[1]['path']);
        $this->assertSame('nav-primary__item nav-primary__item--search', $siteHeaderNavItems[1]['classes']);
        $this->assertSame($this->linkItem2['rel'], $siteHeaderNavItems[1]['rel']);

        $this->assertSame($this->linkItem3['text'], $siteHeaderNavItems[2]['text']);
        $this->assertSame($this->linkItem3['path'], $siteHeaderNavItems[2]['path']);
        $this->assertSame('nav-primary__item nav-primary__item--last', $siteHeaderNavItems[2]['classes']);
        $this->assertSame($this->linkItem3['rel'], $siteHeaderNavItems[2]['rel']);
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
        $navLinkItems = [
            NavLinkedItem::asLink(new Link('item 1', '/item-1/'), false),
            NavLinkedItem::asLink(new Link('item 2', '/item-2/'), false),
        ];

        return [
            [SiteHeaderNavBar::primary($navLinkItems)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/site-header-nav-bar.mustache';
    }
}

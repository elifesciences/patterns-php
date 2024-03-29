<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\LoginControl;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\SiteHeaderNavBar;

final class SecondarySiteHeaderNavBarTest extends ViewModelTest
{
    private $button;
    private $linkItem1;
    private $linkItem2;
    private $linkItem3;
    private $linkItem4;
    private $linkItems;
    private $siteHeaderNavBar;

    public function setUp()
    {
        parent::setUp();
        $this->button = Button::form('button text', 'button', 'name');

        $this->linkItem1 = NavLinkedItem::asLink(new Link('item 1', '/item-1/'), true);
        $this->linkItem2 = NavLinkedItem::asLink(new Link('item 2', '/item-2/'), false);
        $this->linkItem3 = NavLinkedItem::asLink(new Link('Alerts', '/alerts/'), false);
        $this->linkItem4 = NavLinkedItem::asButton($this->button);
        $this->linkItems = [$this->linkItem1, $this->linkItem2, $this->linkItem3, $this->linkItem4];
        $this->siteHeaderNavBar = SiteHeaderNavBar::secondary($this->linkItems);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $siteHeaderNavItems = $this->siteHeaderNavBar['linkedItems'];

        $this->assertSame($this->linkItem1['text'], $siteHeaderNavItems[0]['text']);
        $this->assertSame($this->linkItem1['path'], $siteHeaderNavItems[0]['path']);
        $this->assertSame('nav-secondary__item nav-secondary__item--first nav-secondary__item--search', $siteHeaderNavItems[0]['classes']);
        $this->assertSame($this->linkItem1['rel'], $siteHeaderNavItems[0]['rel']);

        $this->assertSame($this->linkItem2['text'], $siteHeaderNavItems[1]['text']);
        $this->assertSame($this->linkItem2['path'], $siteHeaderNavItems[1]['path']);
        $this->assertSame('nav-secondary__item', $siteHeaderNavItems[1]['classes']);
        $this->assertSame($this->linkItem2['rel'], $siteHeaderNavItems[1]['rel']);

        $this->assertSame($this->linkItem3['text'], $siteHeaderNavItems[2]['text']);
        $this->assertSame($this->linkItem3['path'], $siteHeaderNavItems[2]['path']);
        $this->assertSame('nav-secondary__item nav-secondary__item--alert', $siteHeaderNavItems[2]['classes']);
        $this->assertSame($this->linkItem3['rel'], $siteHeaderNavItems[2]['rel']);

        $this->assertSame($this->linkItem4['button']->toArray(), $siteHeaderNavItems[3]['button']);
        $this->assertSame('nav-secondary__item nav-secondary__item--last nav-secondary__item--hide-narrow', $siteHeaderNavItems[3]['classes']);
    }

    /**
     * @test
     */
    public function it_has_correct_outer_classes()
    {
        $this->assertSame($this->siteHeaderNavBar['classesOuter'], 'nav-secondary');
    }

    /**
     * @test
     */
    public function it_has_correct_inner_classes()
    {
        $this->assertSame($this->siteHeaderNavBar['classesInner'], 'nav-secondary__list clearfix');
    }

    public function viewModelProvider() : array
    {
        $button = Button::form('button text', 'button', 'name');

        $navLinkItems = [
            NavLinkedItem::asLink(new Link('item 1', '/item-1/'), false),
            NavLinkedItem::asLink(new Link('item 2', '/item-2/'), false),
            NavLinkedItem::asButton($button),
        ];

        return [
            [SiteHeaderNavBar::secondary($navLinkItems)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/site-header-nav-bar.mustache';
    }
}

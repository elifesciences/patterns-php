<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\SiteHeader;
use eLife\Patterns\ViewModel\SiteHeaderNavBar;
use InvalidArgumentException;
use TypeError;

final class SiteHeaderTest extends ViewModelTest
{
    private $homePagePath;
    private $primaryLinks;
    private $secondaryLinks;

    public function setUp()
    {
        parent::setUp();
        $this->homePagePath = '/home/page/path';
        $this->primaryLinks = SiteHeaderNavBar::primary(
          [
            NavLinkedItem::asLink('text-first', '/path/first', [], [], false),
            NavLinkedItem::asLink('text-second', '/path/second', [], [], true),
          ]
        );

        $this->secondaryLinks = SiteHeaderNavBar::secondary(
          [
            NavLinkedItem::asLink('text-first', '/path/first', [], [], false),
            NavLinkedItem::asButton(Button::link('button text', '/button/path'), []),
          ]
        );
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $siteHeader = new SiteHeader($this->homePagePath, $this->primaryLinks, $this->secondaryLinks);
        $this->assertSame($this->homePagePath, $siteHeader['homePagePath']);
        $this->assertSame($this->primaryLinks, $siteHeader['primaryLinks']);
        $this->assertSame($this->secondaryLinks, $siteHeader['secondaryLinks']);
    }

    /**
     * @test
     */
    public function home_page_path_must_not_be_blank()
    {
        $this->expectException(InvalidArgumentException::class);
        new SiteHeader('', $this->primaryLinks, $this->secondaryLinks);
    }

    /**
     * @test
     */
    public function primary_links_must_be_supplied()
    {
        $this->expectException(TypeError::class);
        new SiteHeader($this->homePagePath, null, $this->secondaryLinks);
    }

    /**
     * @test
     */
    public function secondary_links_must_be_supplied()
    {
        $this->expectException(TypeError::class);
        new SiteHeader($this->homePagePath, $this->primaryLinks, null);
    }

    public function viewModelProvider() : array
    {
        $primaryLinks = SiteHeaderNavBar::primary(
          [
            NavLinkedItem::asLink('text-first', '/path/first', [], [], false),
            NavLinkedItem::asLink('text-second', '/path/second', [], [], true),
          ]
        );

        $secondaryLinks = SiteHeaderNavBar::secondary(
          [
            NavLinkedItem::asLink('text-first', '/path/first', [], [], false),
            NavLinkedItem::asButton(Button::link('button text', '/button/path'), []),
          ]
        );

        return [
            [new SiteHeader('/home/page/path', $primaryLinks, $secondaryLinks)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/site-header.mustache';
    }
}

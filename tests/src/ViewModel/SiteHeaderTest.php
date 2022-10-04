<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\Input;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\SearchBox;
use eLife\Patterns\ViewModel\SiteHeader;
use eLife\Patterns\ViewModel\SiteHeaderTitle;
use eLife\Patterns\ViewModel\SiteHeaderNavBar;
use TypeError;

final class SiteHeaderTest extends ViewModelTest
{
    private $title;
    private $primaryLinks;
    private $secondaryLinks;
    private $searchBox;

    public function setUp()
    {
        parent::setUp();
        $this->title = new SiteHeaderTitle('/home/page/path');
        $this->primaryLinks = SiteHeaderNavBar::primary(
            [
                NavLinkedItem::asIcon(new Link('text-first', '/path/first')),
                NavLinkedItem::asLink(new Link('text-first', '/path/first'), false),
                NavLinkedItem::asLink(new Link('text-second', '/path/second'), true),
            ]
        );

        $this->secondaryLinks = SiteHeaderNavBar::secondary(
            [
                NavLinkedItem::asLink(new Link('text-first', '/path/first'), false),
                NavLinkedItem::asButton(Button::link('button text', '/button/path')),
            ]
        );

        $this->searchBox = new SearchBox(
            $compactForm = new CompactForm(
                new Form('/action', 'id', 'GET'),
                new Input('label', 'search', 'name', 'value', 'placeholder'),
                'cta'
            )
        );
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $siteHeader = new SiteHeader($this->title, $this->primaryLinks, $this->secondaryLinks, $this->searchBox);
        $this->assertSame($this->title, $siteHeader['title']);
        $this->assertSame($this->primaryLinks, $siteHeader['primaryLinks']);
        $this->assertSame($this->secondaryLinks, $siteHeader['secondaryLinks']);
        $this->assertSameValuesWithoutOrder($this->searchBox, $siteHeader['searchBox']);
        $this->assertTrue($siteHeader['searchBox']['inContentHeader']);
    }

    /**
     * @test
     */
    public function title_must_be_supplied()
    {
        $this->expectException(TypeError::class);
        new SiteHeader(null, $this->primaryLinks, $this->secondaryLinks);
    }

    /**
     * @test
     */
    public function primary_links_must_be_supplied()
    {
        $this->expectException(TypeError::class);
        new SiteHeader($this->title, null, $this->secondaryLinks);
    }

    /**
     * @test
     */
    public function secondary_links_must_be_supplied()
    {
        $this->expectException(TypeError::class);
        new SiteHeader($this->title, $this->primaryLinks, null);
    }

    public function viewModelProvider() : array
    {
        $title = new SiteHeaderTitle('/home/page/path');

        $primaryLinks = SiteHeaderNavBar::primary(
            [
                NavLinkedItem::asIcon(new Link('text-first', '/path/first')),
                NavLinkedItem::asLink(new Link('text-first', '/path/first'), false),
                NavLinkedItem::asLink(new Link('text-second', '/path/second'), true),
            ]
        );

        $secondaryLinks = SiteHeaderNavBar::secondary(
            [
                NavLinkedItem::asIcon(new Link('text-first', '/path/first')),
                NavLinkedItem::asLink(new Link('text-first', '/path/first'), false),
                NavLinkedItem::asButton(Button::link('button text', '/button/path')),
            ]
        );

        return [
            'minimum' => [new SiteHeader($title, $primaryLinks, $secondaryLinks)],
            'complete' => [new SiteHeader($title, $primaryLinks, $secondaryLinks, $this->searchBox)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/site-header.mustache';
    }
}

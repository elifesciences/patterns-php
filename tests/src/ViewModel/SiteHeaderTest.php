<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Input;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\SearchBox;
use eLife\Patterns\ViewModel\SiteHeader;
use eLife\Patterns\ViewModel\SiteHeaderNavBar;
use InvalidArgumentException;
use TypeError;

final class SiteHeaderTest extends ViewModelTest
{
    private $img;
    private $homePagePath;
    private $primaryLinks;
    private $secondaryLinks;
    private $searchBox;

    public function setUp()
    {
        parent::setUp();
        $this->img = new Picture(
            [
                ['srcset' => '/path/to/svg'],
            ],
            new Image('/path/to/fallback/', [500 => '/path/in/srcset'], 'alt text', [])
        );
        $this->homePagePath = '/home/page/path';
        $this->primaryLinks = SiteHeaderNavBar::primary(
            [
                NavLinkedItem::asIcon(new Link('text-first', '/path/first'), $this->img),
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
        $siteHeader = new SiteHeader($this->homePagePath, $this->primaryLinks, $this->secondaryLinks, $this->searchBox);
        $this->assertSame($this->homePagePath, $siteHeader['homePagePath']);
        $this->assertSame($this->primaryLinks, $siteHeader['primaryLinks']);
        $this->assertSame($this->secondaryLinks, $siteHeader['secondaryLinks']);
        $this->assertSameValuesWithoutOrder($this->searchBox, $siteHeader['searchBox']);
        $this->assertTrue($siteHeader['searchBox']['inContentHeader']);
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
        $img = new Picture(
            [
                ['srcset' => '/path/to/svg'],
            ],
            new Image('/path/to/fallback/', [500 => '/path/in/srcset'], 'alt text', [])
        );

        $primaryLinks = SiteHeaderNavBar::primary(
            [
                NavLinkedItem::asIcon(new Link('text-first', '/path/first'), $img),
                NavLinkedItem::asLink(new Link('text-first', '/path/first'), false),
                NavLinkedItem::asLink(new Link('text-second', '/path/second'), true),
            ]
        );

        $secondaryLinks = SiteHeaderNavBar::secondary(
            [
                NavLinkedItem::asIcon(new Link('text-first', '/path/first'), $img),
                NavLinkedItem::asLink(new Link('text-first', '/path/first'), false),
                NavLinkedItem::asButton(Button::link('button text', '/button/path')),
            ]
        );

        return [
            'minimum' => [new SiteHeader('/home/page/path', $primaryLinks, $secondaryLinks)],
            'complete' => [new SiteHeader('/home/page/path', $primaryLinks, $secondaryLinks, $this->searchBox)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/site-header.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\CompactForm;
use eLife\Patterns\ViewModel\Form;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Input;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\LoginControl;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\SearchBox;
use eLife\Patterns\ViewModel\SiteHeader;
use eLife\Patterns\ViewModel\SiteHeaderLogo;
use eLife\Patterns\ViewModel\SiteHeaderNavBar;
use InvalidArgumentException;
use TypeError;

final class SiteHeaderTest extends ViewModelTest
{
    private $img;
    private $logo;
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
            new Image('/path/to/fallback/', ['2' => '/hi-res/image/path/in/srcset', '1' => '/image/path/in/srcset'], 'alt text')
        );
        $this->logo = new SiteHeaderLogo('/home/page/path');
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
                NavLinkedItem::asLoginControl(LoginControl::notLoggedIn('Log in / Register', '/log-in')),
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
        $siteHeader = new SiteHeader($this->logo, $this->primaryLinks, $this->secondaryLinks, $this->searchBox);
        $this->assertSame($this->logo, $siteHeader['logo']);
        $this->assertSame($this->primaryLinks, $siteHeader['primaryLinks']);
        $this->assertSame($this->secondaryLinks, $siteHeader['secondaryLinks']);
        $this->assertSameValuesWithoutOrder($this->searchBox, $siteHeader['searchBox']);
        $this->assertTrue($siteHeader['searchBox']['inContentHeader']);
    }

    /**
     * @test
     */
    public function logo_must_be_supplied()
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
        new SiteHeader($this->logo, null, $this->secondaryLinks);
    }

    /**
     * @test
     */
    public function secondary_links_must_be_supplied()
    {
        $this->expectException(TypeError::class);
        new SiteHeader($this->logo, $this->primaryLinks, null);
    }

    public function viewModelProvider() : array
    {
        $logo = new SiteHeaderLogo('/home/page/path');

        $img = new Picture(
            [
                ['srcset' => '/path/to/svg'],
            ],
            new Image('/path/to/fallback/', ['2' => '/hi-res/image/path/in/srcset', '1' => '/image/path/in/srcset'], 'alt text')
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
                NavLinkedItem::asLoginControl(LoginControl::notLoggedIn('Log in / Register', '/log-in')),
            ]
        );

        return [
            'minimum' => [new SiteHeader($logo, $primaryLinks, $secondaryLinks)],
            'complete' => [new SiteHeader($logo, $primaryLinks, $secondaryLinks, $this->searchBox)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/site-header.mustache';
    }
}

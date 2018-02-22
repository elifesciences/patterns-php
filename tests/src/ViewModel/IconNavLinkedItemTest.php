<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\Picture;

final class IconNavLinkedItemTest extends ViewModelTest
{
    private $picture;

    public function setUp()
    {
        parent::setUp();
        $this->picture = new Picture(
            [
                ['srcset' => '/path/to/svg'],
            ],
            new Image('/default/image/path', ['2' => '/hi-res/image/path/in/srcset', '1' => '/image/path/in/srcset'], 'alt', ['image-class'])
        );
    }

    /**
     * @test
     */
    public function classSetOnSearchIcon()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->picture, false, true, 'search');
        $this->assertSame('nav-primary__search_icon', $linkNavLinkedItem['picture']->toArray()['pictureClasses']);
    }

    /**
     * @test
     */
    public function classSetOnMenuIcon()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->picture, true, false, 'menu');
        $this->assertSame('nav-primary__menu_icon', $linkNavLinkedItem['picture']->toArray()['pictureClasses']);
    }

    /**
     * @test
     */
    public function text_visible_if_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->picture, true);
        $this->assertNull($linkNavLinkedItem['textClasses']);
    }

    /**
     * @test
     */
    public function text_visible_if_not_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->picture, false);
        $this->assertSame('visuallyhidden', $linkNavLinkedItem['textClasses']);
    }

    /**
     * @test
     */
    public function rel_search_set_if_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->picture, true, true);
        $this->assertSame('search', $linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function rel_search_not_set_if_not_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->picture, true, false);
        $this->assertNull($linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $dataAsIcon = [
            'picture' => $this->picture->toArray(),
            'path' => '/the/path',
            'rel' => 'search',
            'text' => 'the text',
        ];

        $asIcon = NavLinkedItem::asIcon(new Link('the text', '/the/path'), $this->picture, true, true);

        $this->assertSame($dataAsIcon['text'], $asIcon['text']);
        $this->assertSame($dataAsIcon['path'], $asIcon['path']);
        $this->assertSame($dataAsIcon['rel'], $asIcon['rel']);
        $this->assertSame($dataAsIcon, $asIcon->toArray());
    }

    public function viewModelProvider() : array
    {
        $img = new Picture(
            [
                ['srcset' => '/path/to/svg'],
            ],
            new Image('/default/image/path', ['2' => '/hi-res/image/path/in/srcset', '1' => '/image/path/in/srcset'], 'alt', ['image-class'])
        );

        return [
            'shown text' => [NavLinkedItem::asIcon(new Link('the text', '/the/path'), $img, true)],
            'hidden text' => [NavLinkedItem::asIcon(new Link('the text', '/the/path'), $img, false)],
            'search' => [NavLinkedItem::asIcon(new Link('the text', 'the link path'), $img, true, true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/nav-linked-item.mustache';
    }
}

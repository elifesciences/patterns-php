<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\Picture;

final class IconNavLinkedItemTest extends ViewModelTest
{
    private $img;

    public function setUp()
    {
        parent::setUp();
        $this->img = new Picture(
            [
                ['srcset' => '/path/to/svg'],
            ],
            new Image('/default/image/path', [500 => '/image/path/in/srcset'], 'alt', ['image-class'])
        );
    }

    /**
     * @test
     */
    public function classSetOnSearchIcon()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->img, true, true, 'search');
        $this->assertSame('nav-primary__search_icon', $linkNavLinkedItem->picture->getFallbackImage()['classes']);
    }

    /**
     * @test
     */
    public function text_visible_if_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->img, true);
        $this->assertNull($linkNavLinkedItem['textClasses']);
    }

    /**
     * @test
     */
    public function text_visible_if_not_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->img, false);
        $this->assertSame('visuallyhidden', $linkNavLinkedItem['textClasses']);
    }

    /**
     * @test
     */
    public function rel_search_set_if_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->img, true, true);
        $this->assertSame('search', $linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function rel_search_not_set_if_not_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), $this->img, true, false);
        $this->assertNull($linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $dataAsIcon = [
            'img' => $this->img->toArray(),
            'path' => '/the/path',
            'rel' => 'search',
            'text' => 'the text',
        ];

        $asIcon = NavLinkedItem::asIcon(new Link('the text', '/the/path'), $this->img, true, true);

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
            new Image('/default/image/path', [500 => '/default/image/path'], 'alt', ['image-class'])
        );

        return [
            'shown text' => [NavLinkedItem::asIcon(new Link('the text', '/the/path'), $img, true)],
            'hidden text' => [NavLinkedItem::asIcon(new Link('the text', '/the/path'), $img, false)],
            'search' => [NavLinkedItem::asIcon(new Link('the text', 'the link path'), $img, true, true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/nav-linked-item.mustache';
    }
}

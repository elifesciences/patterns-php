<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\Picture;

final class IconNavLinkedItemTest extends ViewModelTest
{
    /**
     * @test
     */
    public function rel_search_set_if_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), true);
        $this->assertSame('search', $linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function rel_search_not_set_if_not_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asIcon(new Link('the text', 'the link path'), false);
        $this->assertNull($linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $dataAsIcon = [
            'path' => '/the/path',
            'rel' => 'search',
            'text' => 'the text',
        ];

        $asIcon = NavLinkedItem::asIcon(new Link('the text', '/the/path'), true);

        $this->assertSame($dataAsIcon['text'], $asIcon['text']);
        $this->assertSame($dataAsIcon['path'], $asIcon['path']);
        $this->assertSame($dataAsIcon['rel'], $asIcon['rel']);
        $this->assertSame($dataAsIcon, $asIcon->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'default' => [NavLinkedItem::asIcon(new Link('the text', '/the/path'))],
            'search' => [NavLinkedItem::asIcon(new Link('the text', 'the link path'), true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/nav-linked-item.mustache';
    }
}

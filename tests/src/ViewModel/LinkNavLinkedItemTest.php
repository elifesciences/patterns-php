<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\NavLinkedItem;

final class LinkNavLinkedItemTest extends ViewModelTest
{
    /**
     * @test
     */
    public function rel_search_set_if_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asLink(new Link('the text', 'the link path'), true);
        $this->assertSame('search', $linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function rel_search_not_set_if_not_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asLink(new Link('the text', 'the link path'), false);
        $this->assertNull($linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $dataAsLink = [
            'path' => '/the/path',
            'rel' => 'search',
            'text' => 'the text',
        ];

        $asLink = NavLinkedItem::asLink(new Link('the text', '/the/path'), true);

        $this->assertSame($dataAsLink['text'], $asLink['text']);
        $this->assertSame($dataAsLink['path'], $asLink['path']);
        $this->assertSame($dataAsLink['rel'], $asLink['rel']);
        $this->assertSame($dataAsLink, $asLink->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'basic' => [NavLinkedItem::asLink(new Link('the text', '/the/path'))],
            'search' => [NavLinkedItem::asLink(new Link('the text', 'the link path'), true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/nav-linked-item.mustache';
    }
}

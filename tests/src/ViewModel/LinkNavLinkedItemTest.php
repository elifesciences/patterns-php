<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\NavLinkedItem;
use eLife\Patterns\ViewModel\PictureSvgWithFallback;
use InvalidArgumentException;

final class LinkNavLinkedItemTest extends ViewModelTest
{
    private $button;
    private $img;

    public function setUp()
    {
        parent::setUp();
        $this->img = new PictureSvgWithFallback(
          [
            ['svg' => '/path/to/svg'],
          ],
          new Image('/default/image/path', [500 => '/image/path/in/srcset'], 'alt', ['image-class'])
        );
    }

    /**
     * @test
     */
    public function it_must_have_non_empty_text()
    {
        $this->expectException(InvalidArgumentException::class);
        NavLinkedItem::asLink('', 'the link path');
    }

    /**
     * @test
     */
    public function it_must_have_non_empty_path()
    {
        $this->expectException(InvalidArgumentException::class);
        NavLinkedItem::asLink('the text', '');
    }

    /**
     * @test
     */
    public function rel_search_set_if_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asLink('the text', 'the link path', [], [], true);
        $this->assertSame('search', $linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function rel_search_not_set_if_not_flagged()
    {
        $linkNavLinkedItem = NavLinkedItem::asLink('the text', 'the link path', [], [], false);
        $this->assertNull($linkNavLinkedItem['rel']);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $dataAsLink = [
          'text' => 'the text',
          'path' => '/the/path',
          'classes' => 'class-1 class-2',
          'textClasses' => 'text-class-1 text-class-2',
          'rel' => 'search',
          'img' => $this->img,
        ];

        $asLink = NavLinkedItem::asLink('the text', '/the/path', ['class-1', 'class-2'], ['text-class-1', 'text-class-2'], true, $this->img);

        $this->assertSame($dataAsLink['text'], $asLink['text']);
        $this->assertSame($dataAsLink['path'], $asLink['path']);
        $this->assertSame($dataAsLink['classes'], $asLink['classes']);
        $this->assertSame($dataAsLink['rel'], $asLink['rel']);
        $this->assertSame($dataAsLink['img'], $asLink['img']);
    }

    public function viewModelProvider() : array
    {
        $img = new PictureSvgWithFallback(
          [
            ['svg' => '/path/to/svg'],
          ],
          new Image('/default/image/path', [500 => '/default/image/path'], 'alt', ['image-class'])
        );

        return [
          'text: basic' => [NavLinkedItem::asLink('the text', '/the/path')],
          'text: with classes' => [NavLinkedItem::asLink('the text', 'the link path', ['class-1', 'class-2'])],
          'text: with classes and text classes' => [NavLinkedItem::asLink('the text', 'the link path', ['class-1', 'class-2'], ['text-class-1', 'text-class-2'])],
          'with all classes & search' => [NavLinkedItem::asLink('the text', 'the link path', ['class-1', 'class-2'], ['text-class-1', 'text-class-2'], true)],
          'with all classes & img' => [NavLinkedItem::asLink('the text', 'the link path', ['class-1', 'class-2'], ['text-class-1', 'text-class-2'], false, $img)],
          'with all classes, img & search' => [NavLinkedItem::asLink('the text', 'the link path', ['class-1', 'class-2'], ['text-class-1', 'text-class-2'], true, $img)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/nav-linked-item.mustache';
    }
}

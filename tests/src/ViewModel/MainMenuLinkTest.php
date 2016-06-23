<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MainMenuLink;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class MainMenuLinkTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $mainMenuLink = new MainMenuLink('title', 'titleId', [new Link('name', 'url')]);

        $this->assertInstanceOf(CastsToArray::class, $mainMenuLink);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = ['title' => 'title', 'titleId' => 'titleId', 'items' => [['name' => 'name', 'url' => 'url']]];

        $mainMenuLink = new MainMenuLink($data['title'], $data['titleId'],
            $items = [new Link($data['items'][0]['name'], $data['items'][0]['url'])]);

        $this->assertSame($data['title'], $mainMenuLink['title']);
        $this->assertSame($data['titleId'], $mainMenuLink['titleId']);
        $this->assertEquals($items, $mainMenuLink['items']);
        $this->assertSame($data, $mainMenuLink->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new MainMenuLink('', 'titleId', [new Link('name', 'url')]);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_title_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new MainMenuLink('title', '', [new Link('name', 'url')]);
    }
}

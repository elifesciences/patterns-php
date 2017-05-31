<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class LinkTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $link = new Link('name', 'url');

        $this->assertInstanceOf(CastsToArray::class, $link);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = ['name' => 'name', 'url' => 'url', 'isCurrent' => true, 'attributes' => [['key' => 'key', 'value' => 'value']]];

        $link = new Link('name', 'url', true, ['key' => 'value']);

        $this->assertSame($data['name'], $link['name']);
        $this->assertSame($data['url'], $link['url']);
        $this->assertSame($data['isCurrent'], $link['isCurrent']);
        $this->assertSame($data['attributes'], $link['attributes']);
        $this->assertSame($data, $link->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_name()
    {
        $this->expectException(InvalidArgumentException::class);

        new Link('', 'url');
    }
}

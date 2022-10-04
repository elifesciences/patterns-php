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
        $data = [
            'name' => 'name',
            'url' => 'url',
            'isCurrent' => true,
            'attributes' => [['key' => 'key', 'value' => 'value']],
            'classes' => 'end-of-group hidden-wide',
        ];

        $link = (new Link('name', 'url', true, ['key' => 'value']))->endOfGroup()->hiddenWide();

        $this->assertSame($data['name'], $link['name']);
        $this->assertSame($data['url'], $link['url']);
        $this->assertSame($data['isCurrent'], $link['isCurrent']);
        $this->assertSame($data['attributes'], $link['attributes']);
        $this->assertSame($data['classes'], $link['classes']);
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

    /**
     * @test
     */
    public function it_may_have_classes()
    {
        $with1 = (new Link('name', 'url'))->endOfGroup();
        $with2 = (new Link('name', 'url'))->hiddenWide();
        $with3 = (new Link('name', 'url'))->endOfGroup()->hiddenWide();
        $without = new Link('name', 'url');

        $this->assertArrayHasKey('classes', $with1->toArray());
        $this->assertSame('end-of-group', $with1->toArray()['classes']);

        $this->assertArrayHasKey('classes', $with2->toArray());
        $this->assertSame('hidden-wide', $with2->toArray()['classes']);

        $this->assertArrayHasKey('classes', $with3->toArray());
        $this->assertSame('end-of-group hidden-wide', $with3->toArray()['classes']);

        $this->assertArrayNotHasKey('classes', $without->toArray());
    }
}

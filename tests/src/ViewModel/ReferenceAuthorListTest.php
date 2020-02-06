<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\ReferenceAuthorList;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ReferenceAuthorListTest extends TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $list = new ReferenceAuthorList([Author::asText('Author')], 'suffix');

        $this->assertInstanceOf(CastsToArray::class, $list);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = ['authors' => [['name' => 'Author', 'url' => false]], 'suffix' => 'suffix'];

        $list = new ReferenceAuthorList([Author::asText($data['authors'][0]['name'])], $data['suffix']);

        $this->assertCount(1, $list['authors']);
        $this->assertSame($data['authors'][0], $list['authors'][0]->toArray());
        $this->assertSame($data['suffix'], $list['suffix']);
        $this->assertSame($data, $list->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_suffix()
    {
        $this->expectException(InvalidArgumentException::class);

        new ReferenceAuthorList([Author::asText('Author')], '');
    }
}

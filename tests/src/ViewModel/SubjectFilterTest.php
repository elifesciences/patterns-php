<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\SubjectFilter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SubjectFilterTest extends TestCase
{
    #[Test]
    public function it_casts_to_an_array()
    {
        $filter = new SubjectFilter('name', 'value', 'text');

        $this->assertInstanceOf(CastsToArray::class, $filter);
    }

    #[Test]
    public function it_has_data()
    {
        $data = [
            'name' => 'name',
            'value' => 'value',
            'text' => 'text',
        ];

        $filter = new SubjectFilter(...array_values($data));

        $this->assertSame($data['name'], $filter['name']);
        $this->assertSame($data['value'], $filter['value']);
        $this->assertSame($data['text'], $filter['text']);
        $this->assertSame($data, $filter->toArray());
    }

    #[Test]
    public function it_cannot_have_a_blank_name()
    {
        $this->expectException(InvalidArgumentException::class);

        new SubjectFilter('', 'value', 'text');
    }

    #[Test]
    public function it_cannot_have_a_blank_value()
    {
        $this->expectException(InvalidArgumentException::class);

        new SubjectFilter('name', '', 'text');
    }

    #[Test]
    public function it_cannot_have_a_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new SubjectFilter('name', 'value', '');
    }
}

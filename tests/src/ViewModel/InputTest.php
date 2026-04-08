<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Input;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;

final class InputTest extends TestCase
{
    #[Test]
    public function it_casts_to_an_array()
    {
        $input = new Input('label', 'text', 'input', 'value', 'placeholder');

        $this->assertInstanceOf(CastsToArray::class, $input);
    }

    #[Test]
    public function it_has_data()
    {
        $data = [
            'label' => 'label',
            'type' => 'text',
            'name' => 'name',
            'value' => 'value',
            'placeholder' => 'placeholder',
        ];

        $input = new Input(...array_values($data));

        $this->assertSame($data['label'], $input['label']);
        $this->assertSame($data['type'], $input['type']);
        $this->assertSame($data['name'], $input['name']);
        $this->assertSame($data['value'], $input['value']);
        $this->assertSame($data['placeholder'], $input['placeholder']);
        $this->assertSame($data, $input->toArray());
    }

    #[Test]
    public function it_cannot_have_a_blank_label()
    {
        $this->expectException(InvalidArgumentException::class);

        new Input('', 'text', 'name');
    }

    #[Test]
    #[DataProvider('invalidTypeProvider')]
    public function it_cannot_have_an_invalid_type($type)
    {
        $this->expectException(InvalidArgumentException::class);

        new Input('label', $type, 'name');
    }

    public static function invalidTypeProvider() : array
    {
        return [
            'empty string'  => [''],
            'foo'           => ['foo'],
        ];
    }

    #[Test]
    public function it_cannot_have_a_blank_name()
    {
        $this->expectException(InvalidArgumentException::class);

        new Input('label', 'text', '');
    }
}

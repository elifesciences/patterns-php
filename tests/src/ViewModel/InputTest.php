<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Input;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class InputTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $input = new Input('label', 'text', 'input', 'value', 'placeholder');

        $this->assertInstanceOf(CastsToArray::class, $input);
    }

    /**
     * @test
     */
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

    /**
     * @test
     */
    public function it_cannot_have_a_blank_label()
    {
        $this->expectException(InvalidArgumentException::class);

        new Input('', 'text', 'name');
    }

    /**
     * @test
     * @dataProvider invalidTypeProvider
     */
    public function it_cannot_have_an_invalid_type()
    {
        $this->expectException(InvalidArgumentException::class);

        new Input('', 'text', 'name');
    }

    public function invalidTypeProvider() : array
    {
        return [
            [''],
            ['foo'],
        ];
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_name()
    {
        $this->expectException(InvalidArgumentException::class);

        new Input('label', 'text', '');
    }
}

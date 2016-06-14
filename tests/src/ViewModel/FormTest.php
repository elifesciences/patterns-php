<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Form;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class FormTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $form = new Form('/foo', 'foo', 'GET');

        $this->assertInstanceOf(CastsToArray::class, $form);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = ['action' => '/foo', 'id' => 'foo', 'method' => 'GET'];

        $form = new Form(...array_values($data));

        $this->assertSame($data['id'], $form['id']);
        $this->assertSame($data['action'], $form['action']);
        $this->assertSame($data['method'], $form['method']);
        $this->assertSame($data, $form->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_action()
    {
        $this->expectException(InvalidArgumentException::class);

        new Form('', 'foo', 'GET');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new Form('/foo', '', 'GET');
    }

    /**
     * @test
     * @dataProvider invalidMethodProvider
     */
    public function it_cannot_have_an_invalid_method()
    {
        $this->expectException(InvalidArgumentException::class);

        new Form('/foo', '', 'GET');
    }

    public function invalidMethodProvider() : array
    {
        return [
            [''],
            ['FOO'],
            ['get'],
        ];
    }
}

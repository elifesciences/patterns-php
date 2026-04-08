<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Form;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;

final class FormTest extends TestCase
{
    #[Test]
    public function it_casts_to_an_array()
    {
        $form = new Form('/foo', 'foo', 'GET');

        $this->assertInstanceOf(CastsToArray::class, $form);
    }

    #[Test]
    public function it_has_data()
    {
        $data = ['action' => '/foo', 'id' => 'foo', 'method' => 'GET'];

        $form = new Form(...array_values($data));

        $this->assertSame($data['id'], $form['id']);
        $this->assertSame($data['action'], $form['action']);
        $this->assertSame($data['method'], $form['method']);
        $this->assertSame($data, $form->toArray());
    }

    #[Test]
    public function it_cannot_have_a_blank_action()
    {
        $this->expectException(InvalidArgumentException::class);

        new Form('', 'foo', 'GET');
    }

    #[Test]
    public function it_cannot_have_a_blank_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new Form('/foo', '', 'GET');
    }

    #[Test]
    #[DataProvider('invalidMethodProvider')]
    public function it_cannot_have_an_invalid_method(string $method)
    {
        $this->expectException(InvalidArgumentException::class);

        new Form('/foo', '', $method);
    }

    public static function invalidMethodProvider() : array
    {
        return [
            'blank string'  => [''],
            'FOO'           => ['FOO'],
            'get'           => ['get'],
        ];
    }
}

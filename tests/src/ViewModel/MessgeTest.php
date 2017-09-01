<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\Message;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class MessgeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $message = new Message('text', 'id');

        $this->assertInstanceOf(CastsToArray::class, $message);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'text',
            'id' => 'id',
        ];

        $message = new Message(...array_values($data));

        $this->assertSame($data['text'], $message['text']);
        $this->assertSame($data['id'], $message['id']);
        $this->assertSame($data, $message->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new Message('', 'id');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new Message('text', '');
    }
}

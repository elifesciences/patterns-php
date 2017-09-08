<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\MessageGroup;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class MessageGroupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $messageGroup = new MessageGroup('id', 'error messsage', 'info message');

        $this->assertInstanceOf(CastsToArray::class, $messageGroup);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'errorText' => 'error messsage',
            'infoText' => 'info messsage',
        ];

        $messageGroup = new MessageGroup(...array_values($data));
        $this->assertSame($data['id'], $messageGroup['id']);
        $this->assertSame($data['errorText'], $messageGroup['errorText']);
        $this->assertSame($data['infoText'], $messageGroup['infoText']);
        $this->assertSame($data, $messageGroup->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_at_least_one_message()
    {
        $this->expectException(InvalidArgumentException::class);

        new MessageGroup('id');
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_id()
    {
        $this->expectException(InvalidArgumentException::class);

        new MessageGroup('', 'error message', 'info message');
    }
}

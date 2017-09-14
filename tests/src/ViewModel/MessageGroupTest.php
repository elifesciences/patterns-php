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
        $messageGroup = new MessageGroup('error messsage', 'info message');

        $this->assertInstanceOf(CastsToArray::class, $messageGroup);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'errorText' => 'error messsage',
            'infoText' => 'info messsage',
        ];

        $messageGroup = new MessageGroup(...array_values($data));
        $this->assertSame($data['errorText'], $messageGroup['errorText']);
        $this->assertSame($data['infoText'], $messageGroup['infoText']);

        // id is unpredictable so must be ignored by the test
        $messageGroupAsArray = $messageGroup->toArray();
        unset($messageGroupAsArray['id']);
        $this->assertSame($data, $messageGroupAsArray);
    }

    /**
     * @test
     */
    public function it_must_have_at_least_one_message()
    {
        $this->expectException(InvalidArgumentException::class);

        new MessageGroup();
    }

    /**
     * @test
     */
    public function it_has_an_id_of_the_expected_format()
    {
        $messageGroupId = (new MessageGroup('error message', 'info message'))['id'];
        $this->assertStringStartsWith('messages_', $messageGroupId);
        $numberPart = (int) substr($messageGroupId, strpos($messageGroupId, '_') + 1);
        $this->assertGreaterThanOrEqual(10e4, $numberPart);
        $this->assertLessThanOrEqual(10e8, $numberPart);
    }
}

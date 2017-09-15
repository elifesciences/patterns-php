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
        $messageGroup = MessageGroup::forInfoText('info message', 'error message');

        $this->assertInstanceOf(CastsToArray::class, $messageGroup);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'errorText' => 'error message',
            'infoText' => 'info message',
        ];

        $messageGroup = MessageGroup::forInfoText($data['infoText'], $data['errorText']);
        $this->assertSame($data['errorText'], $messageGroup['errorText']);
        $this->assertSame($data['infoText'], $messageGroup['infoText']);

        // id is unpredictable so must be ignored by the test
        $messageGroupAsArray = $messageGroup->toArray();
        unset($messageGroupAsArray['id']);
        $this->assertSame($data, $messageGroupAsArray);

        $data = [
            'errorText' => 'error message',
        ];

        $messageGroup = MessageGroup::forErrorText($data['errorText']);
        $this->assertSame($data['errorText'], $messageGroup['errorText']);

        // id is unpredictable so must be ignored by the test
        $messageGroupAsArray = $messageGroup->toArray();
        unset($messageGroupAsArray['id']);
        $this->assertSame($data, $messageGroupAsArray);
    }

    /**
     * @test
     */
    public function it_must_have_info_text()
    {
        $this->expectException(InvalidArgumentException::class);

        MessageGroup::forInfoText('');
    }

    /**
     * @test
     */
    public function it_must_have_error_text()
    {
        $this->expectException(InvalidArgumentException::class);

        MessageGroup::forErrorText('');
    }

    /**
     * @test
     */
    public function it_has_an_id_of_the_expected_format()
    {
        $messageGroupId = (MessageGroup::forInfoText('info message', 'error message'))['id'];
        $this->assertStringStartsWith('messages_', $messageGroupId);
        $numberPart = (int) substr($messageGroupId, strpos($messageGroupId, '_') + 1);
        $this->assertGreaterThanOrEqual(10e4, $numberPart);
        $this->assertLessThanOrEqual(10e8, $numberPart);
    }
}

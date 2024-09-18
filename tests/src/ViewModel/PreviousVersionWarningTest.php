<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\PreviousVersionWarning;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class PreviousVersionWarningTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_castPreviousVersionWarnings_to_an_array()
    {
        $previousVersionWarning = new PreviousVersionWarning('text', new Link('name', 'url'));

        $this->assertInstanceOf(CastsToArray::class, $previousVersionWarning);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'text',
            'link' => [
                'name' => 'name',
                'url' => '#',
            ]
        ];

        $previousVersionWarning = new PreviousVersionWarning('text', new Link('name', '#'));

        $this->assertSame($data['text'], $previousVersionWarning['text']);
        $this->assertSame($data['link']['name'], $previousVersionWarning['link']['name']);
        $this->assertSame($data['link']['url'], $previousVersionWarning['link']['url']);
        $this->assertSame($data, $previousVersionWarning->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new PreviousVersionWarning('');
    }
}

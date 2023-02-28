<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\CastsToArray;
use eLife\Patterns\ViewModel\ContentAsideStatus;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

final class ContentAsideStatusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_casts_to_an_array()
    {
        $status = new ContentAsideStatus('title', 'description', new Link('name', 'url'));

        $this->assertInstanceOf(CastsToArray::class, $status);
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title',
            'titleLength' => 'short',
            'description' => 'description',
            'link' => [
                'name' => 'name',
                'url' => '#',
            ]
        ];

        $status = new ContentAsideStatus('title', 'description', new Link('name', '#'));

        $this->assertSame($data['title'], $status['title']);
        $this->assertSame($data['titleLength'], $status['titleLength']);
        $this->assertSame($data['description'], $status['description']);
        $this->assertSame($data['link']['name'], $status['link']['name']);
        $this->assertSame($data['link']['url'], $status['link']['url']);
        $this->assertSame($data, $status->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentAsideStatus('');
    }

    /**
     * @test
     * @dataProvider titleLengthProvider
     */
    public function a_status_title_has_the_correct_designation_for_its_length(int $length, string $expected)
    {
        $title = str_repeat('e', $length);

        $contentAsideStatus = new ContentAsideStatus(
            $title
        );

        $this->assertSame($expected, $contentAsideStatus['titleLength']);
    }

    public function titleLengthProvider() : array
    {
        return [
            [5, 'short'],
            [15, 'short'],
            [23, 'short'],
            [24, 'long'],
            [30, 'long'],
            [50, 'long'],
        ];
    }
}

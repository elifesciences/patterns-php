<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\IFrame;
use InvalidArgumentException;

final class IFrameTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'src' => 'http://www.example.com/',
            'allowFullScreen' => true,
            'paddingBottom' => 100,
        ];

        $iFrame = new IFrame($data['src'], 100, 100, $data['allowFullScreen']);

        $this->assertSame($iFrame['src'], $data['src']);
        $this->assertSame($iFrame['allowFullScreen'], $data['allowFullScreen']);
        $this->assertSame($iFrame['paddingBottom'], $data['paddingBottom']);
        $this->assertSame($iFrame->toArray(), $data);
    }

    public function viewModelProvider() : array
    {
        return [
            'square' => [new IFrame('http://www.example.com/', 100, 100)],
            'tall' => [new IFrame('http://www.example.com/', 100, 200)],
            'allow full screen' => [new IFrame('http://www.example.com/', 100, 100, true)],
            'don\'t allow full screen' => [new IFrame('http://www.example.com/', 100, 100, false)],
        ];
    }

    /**
     * @test
     */
    public function src_must_not_be_blank()
    {
        $this->expectException(InvalidArgumentException::class);

        new IFrame('', 100, 100);
    }

    /**
     * @test
     */
    public function width_must_be_greater_than_1()
    {
        $this->expectException(InvalidArgumentException::class);

        new IFrame('http://www.example.com/', 0, 100);
    }

    /**
     * @test
     */
    public function height_must_be_greater_than_1()
    {
        $this->expectException(InvalidArgumentException::class);

        new IFrame('http://www.example.com/', 100, 0);
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/iframe.mustache';
    }
}

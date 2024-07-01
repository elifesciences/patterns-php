<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ProcessBlock;
use eLife\Patterns\ViewModel\Link;
use InvalidArgumentException;

final class ProcessBlockTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'body' => 'content',
            'variant' => 'vor',
            'link' => [
                'name' => 'name',
                'url' => 'url'
            ]
        ];

        $processBlock = new ProcessBlock($data['body'], $data['variant'], new Link('name', 'url'));

        $this->assertSame($data['body'], $processBlock['body']);
        $this->assertSame($data['variant'], $processBlock['variant']);
        $this->assertSame($data['link']['name'], $processBlock['link']['name']);
        $this->assertSame($data['link']['url'], $processBlock['link']['url']);
        $this->assertSame($data, $processBlock->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_valid_variant()
    {
        $this->expectException(InvalidArgumentException::class);

        new ProcessBlock('content', 'not valid variant', new Link('name', 'url'));
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ProcessBlock('content')],
            'without link' => [new ProcessBlock('content', 'vor')],
            'maximum' => [new ProcessBlock('content', 'vor', new Link('name', 'url'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/process-block.mustache';
    }
}

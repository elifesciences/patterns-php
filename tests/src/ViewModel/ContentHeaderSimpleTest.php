<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ContentHeaderSimple;
use InvalidArgumentException;

final class ContentHeaderSimpleTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title',
            'strapline' => 'strapline',
        ];

        $contentHeader = new ContentHeaderSimple('title', 'strapline');

        $this->assertSame($data['title'], $contentHeader['title']);
        $this->assertSame($data['strapline'], $contentHeader['strapline']);
        $this->assertSame($data, $contentHeader->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderSimple('');
    }

    public function viewModelProvider(): array
    {
        return [
            'minimum' => [new ContentHeaderSimple('title')],
            'with strapline' => [new ContentHeaderSimple('title', 'strapline')],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/content-header-simple.mustache';
    }
}

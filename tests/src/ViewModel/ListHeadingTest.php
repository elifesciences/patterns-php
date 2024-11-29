<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ListHeading;
use InvalidArgumentException;

final class ListHeadingTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'heading' => 'some heading text',
            'headingId' => 'id',
        ];

        $heading = new ListHeading($data['heading'], $data['headingId']);

        $this->assertSame($heading['heading'], $data['heading'], 'List heading contains heading property');
        $this->assertSame($heading['headingId'], $data['headingId']);
        $this->assertSame($heading->toArray(), $data);
    }

    /**
     * @test
     */
    public function it_cannot_have_a_blank_heading()
    {
        $this->expectException(InvalidArgumentException::class);

        new ListHeading('');
    }

    public function viewModelProvider(): array
    {
        return [
            'complete' => [
                new ListHeading('heading text', 'id'),
            ],
            'minimum' => [
                new ListHeading('heading text'),
            ],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/list-heading.mustache';
    }
}

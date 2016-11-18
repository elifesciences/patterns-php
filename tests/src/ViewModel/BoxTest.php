<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Box;
use eLife\Patterns\ViewModel\Doi;
use InvalidArgumentException;

final class BoxTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'id' => 'id',
            'label' => 'label',
            'title' => 'title',
            'headingLevel' => 1,
            'doi' => [
                'doi' => '10.7554/eLife.10181.001',
            ],
            'content' => 'content',
        ];

        $box = new Box($data['id'], $data['label'], $data['title'], $data['headingLevel'], new Doi($data['doi']['doi']), $data['content']);

        $this->assertSame($data['id'], $box['id']);
        $this->assertSame($data['label'], $box['label']);
        $this->assertSame($data['title'], $box['title']);
        $this->assertSame($data['headingLevel'], $box['headingLevel']);
        $this->assertSame($data['doi'], $box['doi']->toArray());
        $this->assertSame($data['content'], $box['content']);
        $this->assertSame($data, $box->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new Box(null, null, '', 1, null, 'content');
    }

    /**
     * @test
     * @dataProvider headingLevelProvider
     */
    public function it_must_have_a_valid_heading_level(int $headingLevel)
    {
        $this->expectException(InvalidArgumentException::class);

        new Box(null, null, 'title', $headingLevel, null, 'content');
    }

    public function headingLevelProvider() : array
    {
        return [[0], [7]];
    }

    /**
     * @test
     */
    public function it_must_have_content()
    {
        $this->expectException(InvalidArgumentException::class);

        new Box(null, null, 'title', 1, null, '');
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new Box(null, null, 'title', 1, null, 'content')],
            'complete' => [new Box('id', 'label', 'title', 1, new Doi('10.7554/eLife.10181.001'), 'content')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return '/elife/patterns/templates/box.mustache';
    }
}

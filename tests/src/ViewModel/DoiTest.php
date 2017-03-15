<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Doi;
use InvalidArgumentException;

final class DoiTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'doi' => '10.7554/eLife.10181.001',
        ];
        $doi = new Doi($data['doi']);

        $this->assertSame($data['doi'], $doi['doi']);
        $this->assertSame($data, $doi->toArray());
    }

    public function it_must_be_a_doi()
    {
        $this->expectException(InvalidArgumentException::class);

        new Doi('foo');
    }

    public function viewModelProvider() : array
    {
        return [
            [new Doi('10.7554/eLife.10181.001')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/doi.mustache';
    }
}

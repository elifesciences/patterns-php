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

    /**
     * @test
     */
    public function it_must_be_a_doi()
    {
        $this->expectException(InvalidArgumentException::class);

        new Doi('foo');
    }

    /**
     * @test
     */
    public function it_may_not_have_a_link()
    {
        $with = new Doi('10.7554/eLife.00001', true);
        $without = new Doi('10.7554/eLife.00001');

        $this->assertArrayHasKey('doiWithoutLink', $with->toArray());
        $this->assertTrue($with->toArray()['doiWithoutLink']);

        $this->assertArrayNotHasKey('doiWithoutLink', $without->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            ['minimum' => new Doi('10.7554/eLife.10181.001')],
            ['complete' => new Doi('10.7554/eLife.10181.001', true)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/doi.mustache';
    }
}

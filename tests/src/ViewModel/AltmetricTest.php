<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Altmetric;

final class AltmetricTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'doi' => '10.7554/eLife.10181.001',
        ];
        $result = new Altmetric($data['doi']);

        $this->assertSame($data['doi'], $result['doi']);
        $this->assertSame($data, $result->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new Altmetric('10.7554/eLife.10181.001')],
            'complete' => [new Altmetric('10.7554/eLife.10181.001')],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/altmetric.mustache';
    }
}

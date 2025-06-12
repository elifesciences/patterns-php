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
            'donutSize' => 'medium-donut',
            'showBadgeDetails' => true
        ];
        $result = new Altmetric($data['doi'], $data['donutSize'], $data['showBadgeDetails']);

        $this->assertSame($data['doi'], $result['doi']);
        $this->assertSame($data, $result->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'altmetricBadgeWithDetails' => [new Altmetric('10.7554/eLife.10181.001', 'medium-donut', true)],
            'altmetricBadgeWithoutDetails' => [new Altmetric('10.7554/eLife.10181.001', 'donut', false)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/altmetric.mustache';
    }
}

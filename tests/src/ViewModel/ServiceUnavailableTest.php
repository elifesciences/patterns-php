<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ServiceUnavailable;

final class ServiceUnavailableTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'button' => [
                'classes' => 'button--default',
                'path' => '#',
                'text' => 'button',
            ],
        ];

        $serviceUnavailable = new ServiceUnavailable(Button::link('button', '#'));

        $this->assertSame($data['button'], $serviceUnavailable['button']->toArray());
        $this->assertSame($data, $serviceUnavailable->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            'minimum' => [new ServiceUnavailable()],
            'with button' => [new ServiceUnavailable(Button::link('button', '#'))],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/service-unavailable.mustache';
    }
}

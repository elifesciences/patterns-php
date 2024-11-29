<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ClientError;

final class ClientErrorTest extends ViewModelTest
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

        $clientError = new ClientError(Button::link('button', '#'));

        $this->assertSame($data['button'], $clientError['button']->toArray());
        $this->assertSame($data, $clientError->toArray());
    }

    public function viewModelProvider(): array
    {
        return [
            'minimum' => [new ClientError()],
            'with button' => [new ClientError(Button::link('button', '#'))],
        ];
    }

    protected function expectedTemplate(): string
    {
        return 'resources/templates/client-error.mustache';
    }
}

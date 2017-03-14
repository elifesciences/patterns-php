<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ServerError;

final class ServerErrorTest extends ViewModelTest
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

        $serverError = new ServerError(Button::link('button', '#'));

        $this->assertSame($data['button'], $serverError['button']->toArray());
        $this->assertSame($data, $serverError->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ServerError()],
            'with button' => [new ServerError(Button::link('button', '#'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/server-error.mustache';
    }
}

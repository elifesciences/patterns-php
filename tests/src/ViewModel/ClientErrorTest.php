<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ClientError;
use PHPUnit\Framework\Attributes\Test;

final class ClientErrorTest extends ViewModelTest
{
    #[Test]
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

    public static function viewModelProvider() : array
    {
        return [
            'with button' => [new ClientError(Button::link('button', '#'))],
            'minimum' => [new ClientError()],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/client-error.mustache';
    }
}

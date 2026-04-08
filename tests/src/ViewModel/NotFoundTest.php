<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\NotFound;
use PHPUnit\Framework\Attributes\Test;

final class NotFoundTest extends ViewModelTest
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

        $notFound = new NotFound(Button::link('button', '#'));

        $this->assertSame($data['button'], $notFound['button']->toArray());
        $this->assertSame($data, $notFound->toArray());
    }

    public static function viewModelProvider() : array
    {
        return [
            'minimum' => [new NotFound()],
            'with button' => [new NotFound(Button::link('button', '#'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/not-found.mustache';
    }
}

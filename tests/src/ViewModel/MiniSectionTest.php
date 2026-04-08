<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\ListHeading;
use eLife\Patterns\ViewModel\MiniSection;
use PHPUnit\Framework\Attributes\Test;

final class MiniSectionTest extends ViewModelTest
{
    #[Test]
    public function it_has_data()
    {
        $data = [
            'body' => 'body',
            'listHeading' => [
                'heading' => 'my heading',
            ],
        ];
        $miniSection = new MiniSection('body', new ListHeading('my heading'));

        $this->assertSame($data['body'], $miniSection['body']);
        $this->assertSame($data['listHeading'], $miniSection['listHeading']->toArray());
        $this->assertSame($data, $miniSection->toArray());
    }

    public static function viewModelProvider() : array
    {
        return [
            'Body' => [new MiniSection('body')],
            'Body and heading' => [new MiniSection('body', new ListHeading('my heading'))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/mini-section.mustache';
    }
}

<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ButtonCollection;
use eLife\Patterns\ViewModel\Download;

final class DownloadTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => 'foo',
            'buttonCollection' => [
                'buttons' => [
                    [
                        'classes' => 'button--default',
                        'path' => 'path',
                        'text' => 'text',
                    ],
                ],
                'centered' => true,
            ],
        ];

        $download = new Download($data['text'], new ButtonCollection([Button::link($data['buttonCollection']['buttons'][0]['text'], $data['buttonCollection']['buttons'][0]['path'])]));

        $this->assertSame($data['text'], $download['text']);
        $this->assertSame($data['buttonCollection'], $download['buttonCollection']->toArray());
        $this->assertSame($data, $download->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_blank_text()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Download('', new ButtonCollection([Button::link('text', 'path')]));
    }

    public function viewModelProvider() : array
    {
        return [
            [new Download('foo', new ButtonCollection([Button::link('text', 'path')]))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/download.mustache';
    }
}

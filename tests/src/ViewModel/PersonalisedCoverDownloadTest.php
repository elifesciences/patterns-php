<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ButtonCollection;
use eLife\Patterns\ViewModel\Paragraph;
use eLife\Patterns\ViewModel\PersonalisedCoverDownload;
use InvalidArgumentException;

final class PersonalisedCoverDownloadTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'text' => [
                [
                    'text' => 'foo',
                ],
            ],
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

        $download = new PersonalisedCoverDownload(array_map(function (array $paragraph) {
            return new Paragraph($paragraph['text']);
        }, $data['text']), new ButtonCollection([Button::link($data['buttonCollection']['buttons'][0]['text'], $data['buttonCollection']['buttons'][0]['path'])]));

        $this->assertSameWithoutOrder($data['text'], $download['text']);
        $this->assertSame($data['buttonCollection'], $download['buttonCollection']->toArray());
        $this->assertSame($data, $download->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_empty_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new PersonalisedCoverDownload([], new ButtonCollection([Button::link('text', 'path')]));
    }

    /**
     * @test
     */
    public function it_cannot_have_non_paragraph_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new PersonalisedCoverDownload(['foo'], new ButtonCollection([Button::link('text', 'path')]));
    }

    public function viewModelProvider() : array
    {
        return [
            [new PersonalisedCoverDownload([new Paragraph('foo')], new ButtonCollection([Button::link('text', 'path')]))],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/personalised-cover-download.mustache';
    }
}

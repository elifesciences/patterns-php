<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ButtonCollection;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Paragraph;
use eLife\Patterns\ViewModel\PersonalisedCoverDownload;
use eLife\Patterns\ViewModel\Picture;
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
                        'classes' => 'button--default personalised__button button__gtm-download-pdf',
                        'path' => 'path',
                        'text' => 'text',
                    ],
                ],
            ],
            'uncheckedValue' => 'A4',
            'checkedValue' => 'US Letter',
            'image' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
            ],
        ];

        $download = new PersonalisedCoverDownload(array_map(function (array $paragraph) {
            return new Paragraph($paragraph['text']);
        }, $data['text']), new ButtonCollection([
                Button::link(
                    $data['buttonCollection']['buttons'][0]['text'],
                    $data['buttonCollection']['buttons'][0]['path'],
                    Button::SIZE_MEDIUM,
                    Button::STYLE_DEFAULT,
                    true,
                    false,
                    null,
                    $data['buttonCollection']['buttons'][0]['classes']
                ),
            ]),
            $data['uncheckedValue'], $data['checkedValue'], new Picture([], new Image($data['image']['fallback']['defaultPath'])));

        $this->assertSameWithoutOrder($data['text'], $download['text']);
        // remove certain data before comparing, where button attributes are not set
        unset($data['buttonCollection']['buttons'][0]['size']);
        unset($data['buttonCollection']['buttons'][0]['style']);
        $this->assertSame($data['buttonCollection'], $download['buttonCollection']->toArray());
        $this->assertSame($data, $download->toArray());
    }

    /**
     * @test
     */
    public function it_cannot_have_empty_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new PersonalisedCoverDownload([], new ButtonCollection([Button::link('text', 'path')]), '', '', null);
    }

    /**
     * @test
     */
    public function it_cannot_have_non_paragraph_text()
    {
        $this->expectException(InvalidArgumentException::class);

        new PersonalisedCoverDownload(['foo'], new ButtonCollection([Button::link('text', 'path')]), '', '', null);
    }

    public function viewModelProvider() : array
    {
        return [
            [new PersonalisedCoverDownload([new Paragraph('foo')], new ButtonCollection([Button::link('text', 'path')]), '', '', null)],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/personalised-cover-download.mustache';
    }
}

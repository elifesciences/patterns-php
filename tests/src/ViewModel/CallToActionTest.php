<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\CallToAction;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;

final class CallToActionTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'button' => [
                'classes' => 'button--default',
                'path' => '/the/button/path',
                'text' => 'the button text',
            ],
            'image' => [
                'fallback' => [
                    'altText' => 'the alt text',
                    'defaultPath' => '/default/path',
                    'srcset' => '/path/to/image/500/wide 2x, /default/path 1x',
                ],
                'sources' => [
                    [
                        'srcset' => '/path/to/svg',
                    ],
                    [
                        'srcset' => '/path/to/another/svg',
                        'media' => 'media statement',
                    ],
                ],
            ],
            'text' => 'text',
        ];
        $callToAction = new CallToAction(
            new Picture(
                [
                    [
                        'srcset' => '/path/to/svg',
                    ],
                    [
                        'srcset' => '/path/to/another/svg',
                        'media' => 'media statement',
                    ],
                ],
                new Image(
                    '/default/path',
                    ['2' => '/path/to/image/500/wide', '1' => '/default/path'],
                    'the alt text'
                )
            ),
            'text',
            Button::link('the button text', '/the/button/path')
        );

        $this->assertSame($data['image'], $callToAction['image']->toArray());
        $this->assertSame($data['text'], $callToAction['text']);
        $this->assertSame($data['button'], $callToAction['button']->toArray());
        $this->assertSame($data, $callToAction->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            [
                new CallToAction(
                    new Picture([], new Image('/default/path', ['1' => '/default/path'], 'the alt text')),
                    'text',
                    Button::link('the button text', '/the/button/path')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/call-to-action.mustache';
    }
}

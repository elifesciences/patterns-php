<?php

namespace tests\eLife\Patterns\ViewModel;

use DateTimeImmutable;
use Exception;
use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\CallToAction;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Picture;

final class CallToActionTest extends ViewModelTest
{
    /**
     * @test
     * @throws Exception
     */
    public function it_has_data()
    {
        $dateAsString = 'Wednesday, 15-Jan-2020 15:12:24 UTC';
        $date = new DateTimeImmutable($dateAsString);

        $data = [
            'button' => [
                'classes' => 'button--default call-to-action__button',
                'path' => '/the/button/path',
                'text' => 'the button text',
            ],
            'id' => 'some-id',
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
            'needsJs' => true,
            'text' => 'text',
            'dismissible' => [
                'cookieExpires' => $dateAsString,
            ],
        ];
        $callToAction = new CallToAction(
            'some-id',
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
            Button::link('the button text', '/the/button/path'),
            $data['needsJs'], $date
        );

        $this->assertSame($data['id'], $callToAction['id']);
        $this->assertSame($data['image'], $callToAction['image']->toArray());
        $this->assertSame($data['text'], $callToAction['text']);
        $this->assertSame($data['button'], $callToAction['button']->toArray());
        $this->assertSame($data['needsJs'], $callToAction['needsJs']);
        $this->assertSame($dateAsString, $callToAction['dismissible']['cookieExpires']);
        $this->assertSameWithoutOrder($data, $callToAction->toArray());
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [
                new CallToAction(
                    'some-id',
                    new Picture([], new Image('/default/path', ['1' => '/default/path'], 'the alt text')),
                    'text',
                    Button::link('the button text', '/the/button/path')
                ),
            ],
            'complete' => [
                new CallToAction(
                    'some-id',
                    new Picture([], new Image('/default/path', ['1' => '/default/path'], 'the alt text')),
                    'text',
                    Button::link('the button text', '/the/button/path'),
                    true,
                    new DateTimeImmutable('now')
                ),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/call-to-action.mustache';
    }
}

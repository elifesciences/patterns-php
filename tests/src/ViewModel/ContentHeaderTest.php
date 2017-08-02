<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ContentHeader;
use eLife\Patterns\ViewModel\ContentHeaderImage;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Institution;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\Meta;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\Profile;
use eLife\Patterns\ViewModel\Select;
use eLife\Patterns\ViewModel\SelectNav;
use eLife\Patterns\ViewModel\SelectOption;
use InvalidArgumentException;

final class ContentHeaderTest extends ViewModelTest
{
    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title',
        ];

        $contentHeader = new ContentHeader($data['title']);

        $this->assertSame($data['title'], $contentHeader['title']);
        $this->assertSame($data, $contentHeader->toArray());

        $data = [
            'title' => 'titletitletitletitle',
            'longTitle' => true,
            'image' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
                'credit' => [
                    'text' => 'image credit',
                    'overlay' => true,
                ],
            ],
            'impactStatement' => 'impact statement',
            'header' => [
                'possible' => true,
                'hasSubjects' => true,
                'subjects' => [
                    ['name' => 'subject'],
                ],
                'hasProfile' => true,
                'profile' => [
                    'name' => 'profile',
                ],
            ],
            'authors' => [
                'list' => [
                    [
                        'name' => 'author',
                        'isCorresponding' => true,
                    ],
                ],
            ],
            'institutions' => [
                'list' => [
                    [
                        'name' => 'institution',
                    ],
                ],
            ],
            'download' => 'download',
            'button' => [
                'classes' => 'button--default',
                'path' => 'path',
                'text' => 'text',
            ],
            'selectNav' => [
                'route' => '#',
                'select' => [
                    'id' => 'id',
                    'options' => [
                        [
                            'value' => 'value 1',
                            'displayValue' => 'display value 1',
                            'selected' => false,
                        ],
                        [
                            'value' => 'value 2',
                            'displayValue' => 'display value 2',
                            'selected' => true,
                        ],
                        [
                            'value' => 'value 3',
                            'displayValue' => 'display value 3',
                            'selected' => false,
                        ],
                    ],
                    'label' => [
                        'labelText' => 'label',
                        'isVisuallyHidden' => false,
                    ],
                    'name' => 'name',
                ],
                'button' => [
                    'classes' => 'button--default',
                    'text' => 'Search',
                    'type' => 'submit',
                ],
            ],
            'meta' => [
                'text' => 'Research article',
            ],
            'licence' => 'https://creativecommons.org/licenses/by/4.0/',
        ];

        $contentHeader = new ContentHeader(
            $data['title'],
            new ContentHeaderImage(new Picture([], new Image($data['image']['fallback']['defaultPath'])), $data['image']['credit']['text'], $data['image']['credit']['overlay']),
            $data['impactStatement'],
            true,
            array_map(function (array $item) {
                return new Link($item['name']);
            }, $data['header']['subjects']),
            new Profile(new Link($data['header']['profile']['name'])),
            array_map(function (array $item) {
                return Author::asText($item['name'], $item['isCorresponding'] ?? false);
            }, $data['authors']['list']),
            array_map(function (array $item) {
                return new Institution($item['name']);
            }, $data['institutions']['list']),
            $data['download'],
            Button::link($data['button']['text'], $data['button']['path']),
            new SelectNav(
                $data['selectNav']['route'],
                new Select(
                    $data['selectNav']['select']['id'],
                    array_map(function (array $option) {
                        return new SelectOption($option['value'], $option['displayValue'], $option['selected']);
                    }, $data['selectNav']['select']['options']),
                    new FormLabel(
                        $data['selectNav']['select']['label']['labelText'],
                        $data['selectNav']['select']['label']['isVisuallyHidden']
                    ),
                    $data['selectNav']['select']['name']
                ),
                Button::form($data['selectNav']['button']['text'], $data['selectNav']['button']['type'])
            ),
            Meta::withText($data['meta']['text']),
            $data['licence']
        );

        $data['image']['credit']['elementId'] = $contentHeader['image']['credit']['elementId'];

        $this->assertSame($data['title'], $contentHeader['title']);
        $this->assertSame($data['longTitle'], $contentHeader['longTitle']);
        $this->assertSameWithoutOrder($data['image'], $contentHeader['image']);
        $this->assertSame($data['impactStatement'], $contentHeader['impactStatement']);
        $this->assertSameWithoutOrder($data['header'], $contentHeader['header']);
        $this->assertSameWithoutOrder($data['authors'], $contentHeader['authors']);
        $this->assertSameWithoutOrder($data['institutions'], $contentHeader['institutions']);
        $this->assertSame($data['download'], $contentHeader['download']);
        $this->assertSameWithoutOrder($data['button'], $contentHeader['button']);
        $this->assertSameWithoutOrder($data['selectNav'], $contentHeader['selectNav']);
        $this->assertSameWithoutOrder($data['meta'], $contentHeader['meta']);
        $this->assertSame($data['licence'], $contentHeader['licence']);
        $this->assertSame($data, $contentHeader->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeader('');
    }

    /**
     * @test
     */
    public function subjects_must_be_a_links()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeader('', null, null, true, ['foo']);
    }

    /**
     * @test
     */
    public function authors_must_be_authors()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeader('', null, null, false, [], null, ['foo']);
    }

    /**
     * @test
     */
    public function institutions_must_be_institutions()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeader('', null, null, false, [], null, [Author::asText('author')], ['foo']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentHeader('title')],
            'complete' => [
                new ContentHeader('title', new ContentHeaderImage(new Picture([], new Image(
                    '/default/path',
                    '/path/to/image/500/wide',
                    'the alt text',
                    ['class-1', 'class-2'])), 'image credit', true), ' impact statement', true, [new Link('subject', '#')], new Profile(new Link('profile')), [Author::asText('author')], [new Institution('institution')], '#'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-header.mustache';
    }
}

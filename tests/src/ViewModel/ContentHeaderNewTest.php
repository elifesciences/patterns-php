<?php

namespace tests\eLife\Patterns\ViewModel;

use eLife\Patterns\ViewModel\Author;
use eLife\Patterns\ViewModel\Breadcrumb;
use eLife\Patterns\ViewModel\Button;
use eLife\Patterns\ViewModel\ContentHeaderNew;
use eLife\Patterns\ViewModel\ContentHeaderImage;
use eLife\Patterns\ViewModel\ContextualData;
use eLife\Patterns\ViewModel\Doi;
use eLife\Patterns\ViewModel\FormLabel;
use eLife\Patterns\ViewModel\Image;
use eLife\Patterns\ViewModel\Institution;
use eLife\Patterns\ViewModel\Link;
use eLife\Patterns\ViewModel\MetaNew;
use eLife\Patterns\ViewModel\Picture;
use eLife\Patterns\ViewModel\Profile;
use eLife\Patterns\ViewModel\Select;
use eLife\Patterns\ViewModel\SelectNav;
use eLife\Patterns\ViewModel\SelectOption;
use eLife\Patterns\ViewModel\SocialMediaSharers;
use eLife\Patterns\ViewModel\SpeechBubble;
use InvalidArgumentException;

final class ContentHeaderNewTest extends ViewModelTest
{
    public static function buildFixtureForCollection(string $title)
    {
        return new ContentHeaderNew(
            $title,
            new ContentHeaderImage(new Picture([], new Image('/default/path'))),
            null, true, null, [],
            new Profile(new Link('Dr Curator')),
            [], [], null,
            new SocialMediaSharers('some article title', 'https://example.com/some-uri'),
            null, null,
            MetaNew::withLink(new Link('Collection'))
        );
    }

    /**
     * @test
     */
    public function it_has_data()
    {
        $data = [
            'title' => 'title',
            'titleLength' => 'xx-short',
        ];

        $contentHeader = new ContentHeaderNew($data['title']);

        $this->assertSame($data['title'], $contentHeader['title']);
        $this->assertSame($data['titleLength'], $contentHeader['titleLength']);
        $this->assertSame($data, $contentHeader->toArray());

        $data = [
            'title' => 'title',
            'titleLength' => 'xx-short',
            'image' => [
                'fallback' => [
                    'altText' => '',
                    'defaultPath' => '/default/path',
                ],
                'credit' => [
                    'text' => 'image credit',
                ],
                'creditOverlay' => true,
            ],
            'impactStatement' => 'impact statement',
            'socialMediaSharers' => [
                'facebookUrl' => 'https://facebook.com/sharer/sharer.php?u=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'twitterUrl' => 'https://twitter.com/intent/tweet/?text=Some%20article%20title&url=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'emailUrl' => 'mailto:?subject=Some%20article%20title&body=https%3A%2F%2Fexample.com%2Fsome-article-url',
                'redditUrl' => 'https://reddit.com/submit/?title=Some%20article%20title&url=https%3A%2F%2Fexample.com%2Fsome-article-url',
            ],
            'contextualData' => [
                'metricsData' => [
                    'data' => [
                        [
                            'text' => 'foo',
                        ],
                    ],
                    'annotationCount' => [
                        'text' => '<span aria-hidden="true"><span data-visible-annotation-count></span></span><span class="visuallyhidden"> Open annotations. The current annotation count on this page is <span data-hypothesis-annotation-count>being calculated</span>.</span>',
                        'isSmall' => true,
                        'behaviour' => 'HypothesisOpener',
                    ],
                ],
                'citation' => [
                    'citeAs' => 'bar',
                    'doi' => [
                        'doi' => '10.7554/eLife.10181.001',
                        'isTruncated' => true,
                    ],
                ],
            ],
            'header' => [
                'possible' => true,
                'hasSubjects' => true,
                'subjects' => [
                    ['name' => 'subject', 'url' => false],
                ],
                'hasProfile' => true,
                'profile' => [
                    'name' => 'profile',
                    'url' => false,
                ],
            ],
            'breadcrumb' => [
                'items' => [
                    [
                        'url' => '#',
                        'name' => 'foo',
                    ],
                ],
            ],
            'authors' => [
                'list' => [
                    [
                        'name' => 'author',
                        'url' => false,
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
                'url' => false,
                'text' => 'Research article',
            ],
            'doi' => [
                'doi' => '10.7554/eLife.10181.001',
            ],
            'licence' => 'https://creativecommons.org/licenses/by/4.0/',
        ];

        $contentHeader = new ContentHeaderNew(
            $data['title'],
            new ContentHeaderImage(new Picture([], new Image($data['image']['fallback']['defaultPath'])), $data['image']['credit']['text'], $data['image']['creditOverlay']),
            $data['impactStatement'],
            true,
            new Breadcrumb(array_map(function ($item) {
                return new Link($item['name'], $item['url']);
            }, $data['breadcrumb']['items'])),
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
            new SocialMediaSharers('Some article title', 'https://example.com/some-article-url'),
            ContextualData::withMetrics(['foo'], 'bar',
                new Doi('10.7554/eLife.10181.001'),
                SpeechBubble::forContextualData()
            ),
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
            MetaNew::withText($data['meta']['text']),
            new Doi($data['doi']['doi']),
            $data['licence']
        );

        $data['image']['credit']['elementId'] = $contentHeader['image']['credit']['elementId'];

        $this->assertSame($data['title'], $contentHeader['title']);
        $this->assertSame($data['titleLength'], $contentHeader['titleLength']);
        $this->assertSameWithoutOrder($data['image'], $contentHeader['image']);
        $this->assertSame($data['impactStatement'], $contentHeader['impactStatement']);
        $this->assertSameWithoutOrder($data['header'], $contentHeader['header']);
        $this->assertSameWithoutOrder($data['breadcrumb'], $contentHeader['breadcrumb']);
        $this->assertSameWithoutOrder($data['authors'], $contentHeader['authors']);
        $this->assertSameWithoutOrder($data['institutions'], $contentHeader['institutions']);
        $this->assertSame($data['download'], $contentHeader['download']);
        $this->assertSameWithoutOrder($data['socialMediaSharers'], $contentHeader['socialMediaSharers']);
        $this->assertSameWithoutOrder($data['contextualData'], $contentHeader['contextualData']);
        $this->assertSameWithoutOrder($data['selectNav'], $contentHeader['selectNav']);
        $this->assertSameWithoutOrder($data['meta'], $contentHeader['meta']);
        $this->assertSameWithoutOrder($data['doi'], $contentHeader['doi']);
        $this->assertSame($data['licence'], $contentHeader['licence']);
        $this->assertSameWithoutOrder($data, $contentHeader->toArray());
    }

    /**
     * @test
     */
    public function it_must_have_a_title()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderNew('');
    }

    /**
     * @test
     */
    public function subjects_must_be_a_links()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderNew('', null, null, true, null, ['foo']);
    }

    /**
     * @test
     */
    public function authors_must_be_authors()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderNew('', null, null, false, null, [], null, ['foo']);
    }

    /**
     * @test
     */
    public function institutions_must_be_institutions()
    {
        $this->expectException(InvalidArgumentException::class);

        new ContentHeaderNew('', null, null, false, null, [], null, [Author::asText('author')], ['foo']);
    }

    /**
     * @test
     * @dataProvider titleLengthProvider
     */
    public function a_title_has_the_correct_designation_for_its_length(int $length, string $expected)
    {
        $title = str_repeat('é', $length);

        $contentHeader = self::buildFixtureForCollection($title);
        $this->assertSame($expected, $contentHeader['titleLength']);
    }

    public function titleLengthProvider() : array
    {
        return [
            [3,   'xx-short'],
            [19,  'xx-short'],
            [20,  'x-short'],
            [35,  'x-short'],
            [36,  'short'],
            [46,  'short'],
            [47,  'medium'],
            [57,  'medium'],
            [58,  'long'],
            [80, 'long'],
            [81, 'x-long'],
            [120, 'x-long'],
            [121, 'xx-long'],
            [500, 'xx-long'],
        ];
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentHeaderNew('title')],
            'complete' => [
                new ContentHeaderNew('title', new ContentHeaderImage(new Picture([], new Image(
                    '/default/path',
                    ['2' => '/path/to/image/500/wide', '1' => '/default/path'],
                    'the alt text')), 'image credit', true), ' impact statement', true, new Breadcrumb([new Link('foo', 'bar')]), [new Link('subject', '#')], new Profile(new Link('profile')), [Author::asText('author')], [new Institution('institution')], '#'),
            ],
        ];
    }

    protected function expectedTemplate() : string
    {
        return 'resources/templates/content-header-journal.mustache';
    }
}

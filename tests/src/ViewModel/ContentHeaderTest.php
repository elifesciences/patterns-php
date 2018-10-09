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
use eLife\Patterns\ViewModel\SocialMediaSharers;
use InvalidArgumentException;

final class ContentHeaderTest extends ViewModelTest
{
    public static function buildFixtureForCollection(string $title)
    {
        return new ContentHeader(
            $title,
            new ContentHeaderImage(new Picture([], new Image('/default/path'))),
            null, true, [],
            new Profile(new Link('Dr Curator')),
            [], [], null,
            new SocialMediaSharers('some article title', 'https://example.com/some-uri'),
            null,
            Meta::withLink(new Link('Collection'))
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

        $contentHeader = new ContentHeader($data['title']);

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
            'licence' => 'https://creativecommons.org/licenses/by/4.0/',
        ];

        $contentHeader = new ContentHeader(
            $data['title'],
            new ContentHeaderImage(new Picture([], new Image($data['image']['fallback']['defaultPath'])), $data['image']['credit']['text'], $data['image']['creditOverlay']),
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
            new SocialMediaSharers('Some article title', 'https://example.com/some-article-url'),
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
        $this->assertSame($data['titleLength'], $contentHeader['titleLength']);
        $this->assertSameWithoutOrder($data['image'], $contentHeader['image']);
        $this->assertSame($data['impactStatement'], $contentHeader['impactStatement']);
        $this->assertSameWithoutOrder($data['header'], $contentHeader['header']);
        $this->assertSameWithoutOrder($data['authors'], $contentHeader['authors']);
        $this->assertSameWithoutOrder($data['institutions'], $contentHeader['institutions']);
        $this->assertSame($data['download'], $contentHeader['download']);
        $this->assertSameWithoutOrder($data['socialMediaSharers'], $contentHeader['socialMediaSharers']);
        $this->assertSameWithoutOrder($data['selectNav'], $contentHeader['selectNav']);
        $this->assertSameWithoutOrder($data['meta'], $contentHeader['meta']);
        $this->assertSame($data['licence'], $contentHeader['licence']);
        $this->assertSameWithoutOrder($data, $contentHeader->toArray());
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

    /**
     * @test
     */
    public function a_title_shorter_than_20_characters_is_xx_short()
    {
        $title = 'Deoxyribosylthymine';
        $this->assertLessThan(20, strlen($title));

        $contentHeader = self::buildFixtureForCollection($title);
        $this->assertSame('xx-short', $contentHeader['titleLength']);
    }

    /**
     * @test
     */
    public function a_title_between_20_and_38_characters_long_is_x_short()
    {
        $titles = [
            'Scientist and Parent',
            'Acetylcholinesterase wins synapse wars',
        ];
        foreach ($titles as $title) {
            $this->assertGreaterThanOrEqual(20, strlen($title));
            $this->assertLessThanOrEqual(38, strlen($title));

            $contentHeader = self::buildFixtureForCollection($title);
            $this->assertSame('x-short', $contentHeader['titleLength']);
        }
    }

    /**
     * @test
     */
    public function a_title_between_39_and_46_characters_long_is_short()
    {
        $titles = [
            'Reproducibility Project: Cancer Biology',
            'Personality links with lifespan in chimpanzees',
        ];

        foreach ($titles as $title) {
            $this->assertGreaterThanOrEqual(39, strlen($title));
            $this->assertLessThanOrEqual(46, strlen($title));

            $contentHeader = self::buildFixtureForCollection($title);
            $this->assertSame('short', $contentHeader['titleLength']);
        }
    }

    /**
     * @test
     */
    public function a_title_between_47_and_57_characters_long_is_medium()
    {
        $titles = [
            'Mechanistic Microbiome Studies: A Special Issue',
            'The motor thalamus supports striatum-driven reinforcement',
        ];

        foreach ($titles as $title) {
            $this->assertGreaterThanOrEqual(47, strlen($title));
            $this->assertLessThanOrEqual(57, strlen($title));

            $contentHeader = self::buildFixtureForCollection($title);
            $this->assertSame('medium', $contentHeader['titleLength']);
        }
    }

    /**
     * @test
     */
    public function a_title_between_58_and_118_characters_long_is_long()
    {
        $titles = [
            'eLife\'s Multi-format Plain-language Summaries of Research.',
            'Dopamine neuron glutamate cotransmission evokes a delayed excitation lateral dorsal striatal cholinergic interneurons.',
        ];

        foreach ($titles as $title) {
            $this->assertGreaterThanOrEqual(58, strlen($title));
            $this->assertLessThanOrEqual(118, strlen($title));

            $contentHeader = self::buildFixtureForCollection($title);
            $this->assertSame('long', $contentHeader['titleLength']);
        }
    }

    /**
     * @test
     */
    public function a_title_between_119_and_155_characters_long_is_x_long()
    {
        $titles = [
            'Ezrin enrichment on curved membranes requires a specific conformation or interaction with a curvature-sensitive partner',
            'Kasugamycin potentiates rifampicin and limits emergence of resistance in Mycobacterium tuberculosis by specifically decreasing mycobacterial mistranslation',
        ];

        foreach ($titles as $title) {
            $this->assertGreaterThanOrEqual(119, strlen($title));
            $this->assertLessThanOrEqual(155, strlen($title));

            $contentHeader = self::buildFixtureForCollection($title);
            $this->assertSame('x-long', $contentHeader['titleLength']);
        }
    }

    /**
     * @test
     */
    public function a_title_longer_than_155_characters_is_xx_long()
    {
        $title = 'Glutathione de novo synthesis but not recycling process coordinates with glutamine catabolism to control redox homeostasis and directs murine T cell differentiation';
        $this->assertGreaterThan(155, strlen($title));

        $contentHeader = self::buildFixtureForCollection($title);
        $this->assertSame('xx-long', $contentHeader['titleLength']);
    }

    public function viewModelProvider() : array
    {
        return [
            'minimum' => [new ContentHeader('title')],
            'complete' => [
                new ContentHeader('title', new ContentHeaderImage(new Picture([], new Image(
                    '/default/path',
                    ['2' => '/path/to/image/500/wide', '1' => '/default/path'],
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
